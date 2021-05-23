<?php
namespace Sonata;

use Illuminate\Support\Str;

class Factory
{
    public static function factory($class, $count, $attributes = []) {
        $version = app()::VERSION;
        if (Str::startsWith($version, "8")) {
            return $class::factory($attributes)->count($count)->create();
        }

        return factory($class, $count)->create($attributes);
    }
}
