<?php

namespace Tests\Feature;

use App\Filament\Pages\EditSite;
use App\Filament\Pages\LeadsBoard;
use App\Mail\LeadAcknowledgement;
use App\Models\Lead;
use App\Models\User;
use App\Support\Finance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_homepage_uses_editable_copy_and_has_no_footer_form(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Capital al ritmo de tu empresa.');
        $response->assertSee('/images/hero-emprendedora.jpg', false);
        $response->assertSee('/images/problem-negocio.jpg', false);
        $response->assertSee('/images/case-daniela.jpg', false);
        $response->assertSee('Solicitar este monto');
        $response->assertSee('WhatsApp');
        $response->assertSee('NIT');
        $response->assertDontSee('Quiero saber si califico');
        $response->assertDontSee('name="company"', false);
    }

    public function test_calculator_request_saves_a_lead_and_sends_email(): void
    {
        Mail::fake();

        $response = $this->postJson('/solicitudes', [
            'email' => 'Ana@Empresa.com',
            'whatsapp' => '+502 5555 1234',
            'nit' => '1234567-8',
            'amount' => 50000,
            'days' => 60,
        ]);

        $response->assertCreated();
        $response->assertJsonPath('ok', true);
        $response->assertJsonFragment([
            'title' => 'Listo. Nos vamos a comunicar contigo.',
        ]);

        $lead = Lead::query()->first();
        $this->assertNotNull($lead);
        $this->assertSame('ana@empresa.com', $lead->email);
        $this->assertSame('1234567-8', $lead->nit);
        $this->assertSame(50000, $lead->invoice_amount);
        $this->assertSame(43200, $lead->payout_amount);
        $this->assertSame(Lead::STATUS_NEW, $lead->status);
        $this->assertNotNull($lead->email_sent_at);

        Mail::assertSent(LeadAcknowledgement::class, function (LeadAcknowledgement $mail) use ($lead) {
            return $mail->hasTo($lead->email)
                && $mail->envelope()->subject === 'Recibimos tu solicitud en Facilita Capital';
        });
    }

    public function test_calculator_request_rejects_an_invalid_nit(): void
    {
        Mail::fake();

        $this->postJson('/solicitudes', [
            'email' => 'ana@empresa.com',
            'whatsapp' => '55551234',
            'nit' => 'abc',
            'amount' => 50000,
            'days' => 60,
        ])->assertUnprocessable();

        $this->assertSame(0, Lead::query()->count());
        Mail::assertNothingSent();
    }

    public function test_admin_can_open_the_editor_and_the_kanban(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin/contenido')->assertOk();
        $this->actingAs($user)->get('/admin/leads')->assertOk();

        Livewire::actingAs($user)
            ->test(EditSite::class)
            ->call('save')
            ->assertHasNoErrors();
    }

    public function test_guest_cannot_open_the_kanban(): void
    {
        $this->get('/admin/leads')->assertRedirect('/admin/login');
    }

    public function test_admin_can_move_a_lead_on_the_kanban(): void
    {
        $user = User::factory()->create();
        $lead = Lead::query()->create([
            'email' => 'ana@empresa.com',
            'whatsapp' => '50255551234',
            'nit' => '12345678',
            'invoice_amount' => 50000,
            'term_days' => 60,
            'advance_amount' => 45000,
            'cost_amount' => 1800,
            'payout_amount' => 43200,
            'status' => Lead::STATUS_NEW,
            'position' => 1,
        ]);

        Livewire::actingAs($user)
            ->test(LeadsBoard::class)
            ->call('move', $lead->id, Lead::STATUS_CONTACTED)
            ->assertOk();

        $this->assertSame(Lead::STATUS_CONTACTED, $lead->fresh()->status);
    }

    public function test_finance_matches_the_public_estimate(): void
    {
        $result = Finance::simulate(50000, 60);

        $this->assertSame(45000, $result['advance']);
        $this->assertSame(1800, $result['cost']);
        $this->assertSame(43200, $result['today']);
        $this->assertSame(5000, $result['holdback']);
        $this->assertSame(10000, Finance::clamp(1));
        $this->assertSame(2000000, Finance::clamp(9000000));
    }
}
