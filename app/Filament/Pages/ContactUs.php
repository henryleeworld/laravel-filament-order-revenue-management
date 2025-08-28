<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class ContactUs extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Envelope;

    protected string $view = 'filament.pages.contact-us';

    public static function getNavigationLabel(): string
    {
        return __('Contact us');
    }

    public function getTitle(): string
    {
        return __('Contact us');
    }
}
