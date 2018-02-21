<?php
// Some global functions for convenience

function base_path(string $suffix)
{
    return __DIR__ . "/" . $suffix;
}

function storage_path(string $suffix)
{
    return env('STORAGE_PATH', __DIR__ . "/storage") . "/" . $suffix;
}

function app_deploy(): string
{
    return config('app.deploy');
}

function translate($key): string
{
    return config('translation.' . config('app.language') . "." . $key, "__no_translation__");
}