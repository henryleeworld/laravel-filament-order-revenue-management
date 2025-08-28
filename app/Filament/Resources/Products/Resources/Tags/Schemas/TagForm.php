<?php

namespace App\Filament\Resources\Products\Resources\Tags\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                Select::make('company_id')
                    ->label(__('Company'))
                    ->relationship('company', 'name')
                    ->required(),
            ]);
    }
}
