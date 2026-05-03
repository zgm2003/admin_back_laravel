<?php

declare(strict_types=1);

return [
    'version' => env('API_VERSION', 'v1'),

    'pagination' => [
        'default_per_page' => (int) env('API_DEFAULT_PER_PAGE', 15),
        'max_per_page' => (int) env('API_MAX_PER_PAGE', 100),
    ],
];
