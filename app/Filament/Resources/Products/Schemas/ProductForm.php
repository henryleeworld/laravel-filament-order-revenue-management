<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Enums\ProductStatusEnum;
use App\Filament\Tables\CategoriesTable;
use Filament\Forms\Components\ModalTableSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Wizard::make()->steps([
                    Step::make(__('Main data'))
                        ->schema([
                            TextInput::make('name')
                                ->label(__('Product'))
                                ->required()
                                ->columnSpanFull()
                                // ->hiddenOn('edit')
                                // ->disabledOn('edit')
                                // ->live()
                                // ->afterStateUpdated(function (Set $set, $state) {
                                //     $set('slug', str()->slug($state));
                                // })
                                ->unique(),
                            // TextInput::make('slug')
                            //     ->required(),
                            TextInput::make('price')
                                ->label(__('Price'))
                                ->required()
                                ->prefix('NT$')
                                ->rule('numeric'),
                        ]),
                    Step::make(__('Additional data'))
                        ->schema([
                            Select::make('status')
                                ->label(__('Status'))
                                ->options(ProductStatusEnum::class)
                                ->required(),
                            Select::make('tags')
                                ->label(__('Tags'))
                                ->relationship('tags', 'name')
                                ->multiple(),
                            ModalTableSelect::make('category_id')
                                ->label(__('Category'))
                                ->relationship('category', 'name')
                                ->tableConfiguration(CategoriesTable::class),
                            Select::make('company_id')
                                ->label(__('Company'))
                                ->relationship('company', 'name')
                                ->required(),
                        ]),
                ])
            ]);
    }
}
