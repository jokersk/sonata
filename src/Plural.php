<?php
namespace Sonata;

use Illuminate\Support\Str;

class Plural
{
    public static function with($name)
    {
        $plural = Str::plural($name);
        if ($plural === $name) {
            $plural = $name.'s';
        }
        return $plural;
    }
}
