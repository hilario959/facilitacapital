<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Mail\LeadAcknowledgement;
use App\Models\Lead;
use App\Models\SiteSetting;
use App\Support\Finance;
use App\Support\SiteContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request): JsonResponse|RedirectResponse
    {
        $amount = Finance::clamp((float) $request->validated('amount'));
        $days = (int) $request->validated('days');
        $simulation = Finance::simulate($amount, $days);

        $lead = Lead::query()->create([
            'email' => $request->validated('email'),
            'whatsapp' => $request->validated('whatsapp'),
            'nit' => $request->validated('nit'),
            'invoice_amount' => $simulation['amount'],
            'term_days' => $simulation['days'],
            'advance_amount' => $simulation['advance'],
            'cost_amount' => $simulation['cost'],
            'payout_amount' => $simulation['today'],
            'status' => Lead::STATUS_NEW,
            'position' => (int) Lead::query()->where('status', Lead::STATUS_NEW)->max('position') + 1,
        ]);

        $content = SiteSetting::content();

        try {
            Mail::to($lead->email)->send(new LeadAcknowledgement($lead, $content['mail']));
            $lead->update([
                'email_sent_at' => now(),
                'email_error' => null,
            ]);
        } catch (Throwable $exception) {
            report($exception);
            $lead->update([
                'email_error' => Str::limit($exception->getMessage(), 500),
            ]);
        }

        $payload = [
            'ok' => true,
            'title' => $content['lead_form']['success_title'],
            'text' => SiteContent::replaceTokens($content['lead_form']['success_text'], $lead),
        ];

        if ($request->expectsJson()) {
            return response()->json($payload, 201);
        }

        return redirect()
            ->route('home')
            ->with('lead_sent', $payload);
    }
}
