<?php

namespace Sonata\Relations;

use Sonata\Plural;
use Illuminate\Support\Str;
use Sonata\Relations\AbstractRelation;

class HasOne extends AbstractRelation
{
    public function handle($parent, $child)
    {
        $parent->{$this->methodName($child)}()->save($child);
    }
}
