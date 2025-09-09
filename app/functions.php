<?php

function env($key)
{
    return getenv($key);
}

function view($view, $data = [])
{
    extract($data);
    require __ROOT__ . "/app/View/{$view}.php";
}

function asset($path) {
    return '/public/styles/' . ltrim($path, '/');
}