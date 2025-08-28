<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersPerDayChart extends ChartWidget
{
    protected ?string $heading = 'Orders per day';

    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '300px';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $data = Trend::model(Order::class)
            ->between(
                start: now()->subDays(60),
                end: now(),
            )
            ->perDay()
            ->count();
 
        return [
            'datasets' => [
                [
                    'label' => __('Orders per day'),
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    public function getHeading(): string
    {
        return __('Orders per day');
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
