<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderStatusEnum;


class OrderChart extends ChartWidget

{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $data = Order::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => array_values($data)
                ]
            ],
            'labels' => OrderStatusEnum::cases()
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
