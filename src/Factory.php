<?php

namespace Sonata;

class Factory
{
    public static function factory($class, $count, $attributes = [])
    {
        $version = app()::VERSION;
        if (version_compare($version, '8') >= 0) {
            return $class::factory($attributes)->count($count)->create();
        }

        return factory($class, $count)->create($attributes);
    }
}
