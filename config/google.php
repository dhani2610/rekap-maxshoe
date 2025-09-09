<?php
return [
    'application_name' => env('GOOGLE_APPLICATION_NAME', 'Laravel Google Sheets'),

    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect_uri' => env('GOOGLE_REDIRECT'),

    'service' => [
        'enable' => env('GOOGLE_SERVICE_ENABLED', true),
        'file'   => storage_path('credentials.json'),
    ],

    'post_spreadsheet_id' => env('POST_SPREADSHEET_ID'),
];
