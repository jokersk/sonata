<?php
namespace Sonata\Relations;

use Illuminate\Support\Str;
use Sonata\Plural;
use Sonata\Relations\AbstractRelation;

class MorphToMany extends AbstractRelation
{
    public function handle($parent, $child)
    {
        $parent->{$this->methodName($child)}()->attach($child);
        $parent->save();
    }

    public function getMethodName($child)
    {
        return Plural::with(parent::getMethodName($child));
    }
}
