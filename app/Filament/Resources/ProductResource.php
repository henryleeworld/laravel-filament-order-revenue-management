<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    protected static int $globalSearchResultsLimit = 3;

    protected static array $statuses = [
        'in stock' => 'in stock',
        'sold out' => 'sold out',
        'coming soon' => 'coming soon',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make(__('Main data'))
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label(__('Product name'))
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', str()->slug($state))),
                            Forms\Components\TextInput::make('slug')
                                ->label(__('Slug'))
                                ->disabledOn('edit')
                                ->required(),
                            Forms\Components\TextInput::make('price')
                                ->label(__('Price'))
                                ->required(),
                        ]),
                    Forms\Components\Wizard\Step::make(__('Additional data'))
                        ->schema([
                            Forms\Components\Radio::make('status')
                                ->label(__('Status'))
                                ->options(array_map('__', static::$statuses)),
                            Forms\Components\Select::make('category_id')
                                ->label(__('Category'))
                                ->relationship('category', 'name'),
                        ]),
                ])
            ]);
    }

    public static function getBreadcrumb(): string
    {
        return __('Product');
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return self::getUrl('view', ['record' => $record]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description'];
    }

    public static function getModelLabel(): string
    {
        return __('product');
    }

    public static function getNavigationLabel(): string
    {
        return __('Products');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'view' => Pages\ViewProduct::route('/{record}'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TagsRelationManager::class,
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('name')
                    ->label(__('Name')),
                Infolists\Components\TextEntry::make('price')
                    ->label(__('Price')),
                Infolists\Components\TextEntry::make('is_active')
                    ->label(__('Is active')),
                Infolists\Components\TextEntry::make('status')
                    ->label(__('Status'))
                    ->formatStateUsing(fn (string $state): string => __($state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('Price'))
                    ->sortable()
                    ->money('usd')
                    ->getStateUsing(function (Product $record): float {
                        return $record->price / 100;
                    })
                    ->alignRight(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(__('Is active')),
                Tables\Columns\SelectColumn::make('status')
                    ->label(__('Status'))
                    ->options(array_map('__', static::$statuses)),
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('Category name')),
                Tables\Columns\TextColumn::make('tags.name')
                    ->label(__('Tags'))
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options(self::$statuses),
                Tables\Filters\SelectFilter::make('category')
                    ->label(__('Category'))
                    ->relationship('category', 'name'),
                Tables\Filters\Filter::make('created_from')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label(__('Created from')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            );
                    }),
                Tables\Filters\Filter::make('created_until')
                    ->form([
                        Forms\Components\DatePicker::make('created_until')->label(__('Created until')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(4)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('price', 'desc')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
