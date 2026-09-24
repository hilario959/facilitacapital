<?php

namespace App\Filament\Pages;

use App\Models\Lead;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;

class LeadsBoard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedViewColumns;

    protected static ?string $navigationLabel = 'Leads';

    protected static ?string $title = 'Leads';

    protected static ?string $slug = 'leads';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.leads-board';

    public ?int $selectedId = null;

    public string $notes = '';

    public string $status = Lead::STATUS_NEW;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    /**
     * @return Collection<string, Collection<int, Lead>>
     */
    public function columns(): Collection
    {
        $leads = Lead::query()
            ->orderBy('position')
            ->orderByDesc('id')
            ->get()
            ->groupBy('status');

        return collect(Lead::STATUSES)->map(
            fn (string $label, string $status) => $leads->get($status, collect()),
        );
    }

    public function move(int $leadId, string $status): void
    {
        if (! array_key_exists($status, Lead::STATUSES)) {
            return;
        }

        $lead = Lead::query()->find($leadId);
        if (! $lead || $lead->status === $status) {
            return;
        }

        $lead->moveTo($status);

        if ($this->selectedId === $lead->id) {
            $this->status = $status;
        }
    }

    public function open(int $leadId): void
    {
        $lead = Lead::query()->findOrFail($leadId);
        $this->selectedId = $lead->id;
        $this->notes = $lead->notes ?? '';
        $this->status = $lead->status;
    }

    public function close(): void
    {
        $this->selectedId = null;
    }

    public function saveSelected(): void
    {
        $lead = Lead::query()->findOrFail($this->selectedId);

        if (! array_key_exists($this->status, Lead::STATUSES)) {
            return;
        }

        $lead->notes = $this->notes;
        if ($lead->status !== $this->status) {
            $lead->save();
            $lead->moveTo($this->status);
        } else {
            $lead->save();
        }

        Notification::make()->success()->title('Lead actualizado')->send();
    }

    public function deleteSelected(): void
    {
        Lead::query()->findOrFail($this->selectedId)->delete();
        $this->selectedId = null;

        Notification::make()->success()->title('Lead eliminado')->send();
    }

    public function selectedLead(): ?Lead
    {
        if (! $this->selectedId) {
            return null;
        }

        return Lead::query()->find($this->selectedId);
    }
}
