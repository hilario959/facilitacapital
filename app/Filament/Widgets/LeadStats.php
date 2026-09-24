<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadStats extends StatsOverviewWidget
{
    protected ?string $heading = 'Solicitudes';

    protected function getStats(): array
    {
        return collect(Lead::STATUSES)
            ->map(fn (string $label, string $status) => Stat::make($label, Lead::query()->where('status', $status)->count()))
            ->values()
            ->all();
    }
}
