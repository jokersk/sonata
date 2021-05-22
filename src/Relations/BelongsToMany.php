<?php

namespace Sonata\Relations;

use Sonata\Plural;
use Illuminate\Support\Str;
use Sonata\Relations\AbstractRelation;

class BelongsToMany extends AbstractRelation
{
    public function handle($parent, $child)
    {
        $parent->{$this->methodName($child)}()->attach($child);
    }

    public function getMethodName($child)
    {
        return Plural::with(parent::getMethodName($child));
    }
}
