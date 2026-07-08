<?php

use Illuminate\Support\Facades\Route;

if (! function_exists('safe_route')) {
    function safe_route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        return Route::has($name) ? route($name, $parameters, $absolute) : '#';
    }
}