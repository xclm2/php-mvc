<?php

/**
 * Retrieves environment variable or returns default value
 * 
 * @param string $key     The environment variable key
 * @param mixed  $default The default value if the key is not found
 * @return mixed          The environment variable value or default
 */
function env($key, $default = null)
{
    return getenv($key) ?: $default;
}

/**
 * Renders a view template with provided data
 * 
 * @param string $view The view file name (without .php extension)
 * @param array  $data Associative array of data to be extracted for the view
 */
function view($view, $data = [])
{
    extract($data);
    require __ROOT__ . "/app/View/{$view}.php";
}

/**
 * Generates a URL for an asset in the public directory
 * 
 * @param string $path The relative path to the asset
 * @return string      The full URL to the asset
 */
function asset($path) {
    return '/public/' . ltrim($path, '/');
}