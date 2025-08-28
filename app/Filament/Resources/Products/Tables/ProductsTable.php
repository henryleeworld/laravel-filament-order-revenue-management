<?php

namespace App\Filament\Resources\Products\Tables;

use App\Enums\ProductStatusEnum;
use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextInputColumn::make('name')
                    ->label(__('Name'))
                    ->rules(['required', 'string', 'max:255', 'min:3']),
                TextColumn::make('price')
                    ->label(__('Price'))
                    ->money('TWD', decimalPlaces: 0) // ->money('EUR', 100)
                    ->alignEnd()
                    // ->formatStateUsing(fn (int $state): float => $state / 100) 
                    ->sortable(),
                SelectColumn::make('status')
                    ->label(__('Status'))
                    ->searchableOptions()
                    ->options(ProductStatusEnum::class),
                ToggleColumn::make('is_active')
                    ->label(__('Is active'))
                    ->onColor('success')
                    ->offColor('danger'),
                TextColumn::make('category.name')
                    ->label(__('Category')),
                    // ->url(fn (Product $record): string => CategoryResource::getUrl('edit', ['record' => $record->category])),
                TextColumn::make('tags.name')
                    ->label(__('Tags'))
                    ->badge(),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('name', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options(ProductStatusEnum::class),
                SelectFilter::make('category')
                    ->label(__('Category'))
                    ->relationship('category', 'name'),
                Filter::make('created_from')
                    ->schema([
                        DatePicker::make('created_from')
                            ->label(__('Created from')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            );
                    }),
                Filter::make('created_until')
                    ->schema([
                        DatePicker::make('created_until')
                            ->label(__('Created until')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                Action::make('Tags') 
                    ->label(__('Tags'))
                    ->icon(Heroicon::OutlinedTag)
                    ->url(fn (Product $record): string => ProductResource::getUrl('tags', ['record' => $record])),
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
