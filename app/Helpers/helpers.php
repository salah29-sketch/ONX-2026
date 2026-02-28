<?php

use Illuminate\Support\Str;

if (!function_exists('str')) {
    function str($string)
    {
        return Str::of($string);
    }
}