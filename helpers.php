<?php
// Some global functions for convenience

function base_path(string $suffix)
{
    return __DIR__ . "/" . $suffix;
}

function storage_path(string $suffix)
{
    return config('app.storage_path') . "/" . $suffix;
}

function app_deploy(): string
{
    return config('app.deploy');
}

function translate(string $key): string
{
    return config('translation.' . config('app.language') . "." . $key, "__no_translation__");
}