<?php

// Here are our configurable values which also import values from ENV variables
return [
    'deploy' => env('DEPLOY', 'local'),
    'debug' => env('DEBUG', true),
    'language' => env('LANGUAGE', 'ru'),
    'storage_path' => env('STORAGE_PATH', __DIR__ . "/../storage/"),
    'public_path' => env('PUBLIC_PATH', __DIR__ . "/../public/"),
];