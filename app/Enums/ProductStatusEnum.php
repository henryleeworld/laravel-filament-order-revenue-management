<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
 
enum ProductStatusEnum: string implements HasColor, HasLabel
{
    case COMING_SOON = 'Coming Soon';
    case IN_STOCK = 'In Stock';
    case SOLD_OUT = 'Sold Out';

    public function getLabel(): string
    {
        return __($this->value);
    }

    public function getColor(): string
    {
        return match ($this) {
            self::IN_STOCK => 'success',
            self::SOLD_OUT => 'danger',
            self::COMING_SOON => 'warning',
        };
    }
}