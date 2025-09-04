<?php

namespace App\Filament\Accountant\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label(__('User'))
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('product_id')
                    ->label(__('Product'))
                    ->relationship('product', 'name')
                    ->required(),
                TextInput::make('price')
                    ->label(__('Price'))
                    ->required()
                    ->numeric()
                    ->prefix('NT$'), // ->prefix('$')
                Toggle::make('is_completed')
                    ->label(__('Is completed'))
                    ->required(),
                Select::make('company_id')
                    ->label(__('Company'))
                    ->relationship('company', 'name')
                    ->required(),
            ]);
    }
}
