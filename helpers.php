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

function language(): string
{
    $language_key = config('app.language');
    if (isset($_SESSION['language'])) {
        $language_key = $_SESSION['language'];
    }
    return $language_key;
}

function translate(string $key): string
{

    return config("translation." . language() . ".$key", "__no_translation__");
}