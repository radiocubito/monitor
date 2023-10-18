<?php

namespace App\Enums;

enum EndpointFrequency: int
{
    case TEN_SECONDS = 10;
    case ONE_MINUTE = 1 * 60;
    case FIVE_MINUTES = 5 * 60;
    case THIRTY_MINUTES = 30 * 60;
    case ONE_HOUR = 60 * 60;

    public function label(): string
    {
        return match ($this) {
             self::TEN_SECONDS => '10 segundos',
             self::ONE_MINUTE => '1 minuto',
             self::FIVE_MINUTES => '5 minutos',
             self::THIRTY_MINUTES => '30 minutos',
             self::ONE_HOUR => '1 hora',
        };
    }
}
