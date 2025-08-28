<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;

class Characters extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Identification;

    protected string $view = 'filament.pages.characters';

    public static function getNavigationLabel(): string
    {
        return __('Characters');
    }

    public function getTitle(): string
    {
        return __('Characters');
    }

    public function table(Table $table): Table
    {
        return $table
            ->records(fn (): array => Http::baseUrl('https://api.disneyapi.dev')
                ->get('character')
                ->collect()
                ->get('data', [])
            )
            ->columns([
                ImageColumn::make('imageUrl')
                    ->label(__('Image URL')),
                TextColumn::make('name')
                    ->label(__('Name')),
            ]);        
    }
}
