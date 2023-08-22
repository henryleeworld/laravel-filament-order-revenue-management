<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ContactUs extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.contact-us';

    public function getTitle(): string
    {
        return __('Contact us');
    }

    public static function getNavigationLabel(): string
    {
        return __('Contact us');
    }
}
