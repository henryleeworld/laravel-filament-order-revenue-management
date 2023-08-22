<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 4;

    /**
     * @deprecated Override the `table()` method to configure the table.
     */
    protected function getTableHeading(): string
    {
        return __('Latest Orders');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at')),
                Tables\Columns\TextColumn::make('product.name')
                    ->label(__('Product')),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User')),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('Price'))
                    ->money('usd')
                    ->getStateUsing(function (Order $record): float {
                        return $record->price / 100;
                    })
            ]);
    }
}
