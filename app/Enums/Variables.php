<?php

namespace App\Enums;

class Variables
{
    public static $measuresStates = [
        'states' => [
            'open' => [
                'name' => 'offen',
                'badge' => 'bg-info',
            ],
            'planned' => [
                'name' => 'teilnehmend',
                'badge' => 'bg-success',
            ],
            'done' => [
                'name' => 'abgeschlossen',
                'badge' => 'bg-danger',
            ],
            'closed' => [
                'name' => 'abgemeldet',
                'badge' => 'bg-info',
            ],
        ],
    ];
}
