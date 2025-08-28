<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalRevenueStats extends StatsOverviewWidget
{
    protected ?string $pollingInterval = NULL;

    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Revenue today (NTD)',
                number_format(Order::whereDate('created_at', date('Y-m-d'))->sum('price')))
                // number_format(Order::whereDate('created_at', date('Y-m-d'))->sum('price') / 100, 2))
                ->label(__('Revenue today (NTD)')),
            Stat::make('Revenue last 7 days (NTD)',
                number_format(Order::where('created_at', '>=', now()->subDays(7)->startOfDay())->sum('price')))
                // number_format(Order::where('created_at', '>=', now()->subDays(7)->startOfDay())->sum('price') / 100, 2))
                ->label(__('Revenue last 7 days (NTD)')),
            Stat::make('Revenue last 30 days (NTD)',
                number_format(Order::where('created_at', '>=', now()->subDays(30)->startOfDay())->sum('price')))
                // number_format(Order::where('created_at', '>=', now()->subDays(30)->startOfDay())->sum('price') / 100, 2))
                ->label(__('Revenue last 30 days (NTD)'))
        ];
    }
}
