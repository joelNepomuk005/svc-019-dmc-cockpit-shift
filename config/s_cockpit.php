<?php

return [
    'oauth' => [
        'client_id' => env('SCOCKPIT_CLIENT_ID'),
        'client_secret' => env('SCOCKPIT_CLIENT_SECRET'),
        'redirect' => env('SCOCKPIT_REDIRECT'),
        'api_url' => env('SCOCKPIT_API'),
    ],
    'portal-api' => [
        'token' => env('SCOCKPIT_PORTAL_API_TOKEN'),
        'portal_id' => env('SCOCKPIT_PORTAL_ID'),
    ],
];
