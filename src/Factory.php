<?php
namespace Sonata;

use Illuminate\Support\Str;

class Factory
{
    public static function factory($class, $count) {
        $version = app()::VERSION;
        if (Str::startsWith($version, "8")) {
            return $class::factory()->count($count)->create();
        }

        return factory($class, $count)->create();
    }
}
