<?php

namespace Sonata\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Sonata\Sonata;

/**
 *
 */
trait LetsPlaySonata
{
    public function __call($name, $args)
    {
        $sonata = new Sonata;
        if (method_exists($sonata, $name)) {
            return $sonata->$name(...$args);
        }

        return parent::__call();
    }
}
