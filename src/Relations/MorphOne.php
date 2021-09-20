<?php

namespace Sonata\Relations;

use Illuminate\Support\Str;
use Sonata\Plural;
use Sonata\Relations\AbstractRelation;

class MorphOne extends AbstractRelation
{
    public function handle($parent, $child)
    {
        $parent->{$this->methodName($child)}()->save($child);
    }

    public function getMethodName($child)
    {
        return parent::getMethodName($child);
    }
}
