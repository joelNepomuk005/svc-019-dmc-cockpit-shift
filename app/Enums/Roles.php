<?php

namespace App\Enums;

class Roles
{
    const DEVELOPER = 'Entwickler'; // digitalbynature

    const ADMINISTRATOR = 'Administrator'; // S-Markt & Mehrwert

    const USER = 'Standardnutzer'; // S-Markt & Mehrwert

    const ADMINISTRATOR_SMM = 'Administrator (S-MM)';

    const CONSULTANT = 'Berater';

    public static $var = [
        'DEVELOPER' => ['name' => self::DEVELOPER, 'home' => '/backend/dashboard'],
        'ADMINISTRATOR' => ['name' => self::ADMINISTRATOR, 'home' => '/backend/dashboard'],
        'ADMINISTRATOR_SMM' => ['name' => self::ADMINISTRATOR_SMM, 'home' => '/backend/dashboard'],
        'CONSULTANT' => ['name' => self::CONSULTANT, 'home' => '/frontend'],
    ];
}
