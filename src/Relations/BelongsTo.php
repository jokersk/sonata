<?php
namespace Sonata\Relations;

use Illuminate\Support\Str;
use Sonata\Relations\AbstractRelation;

class BelongsTo extends AbstractRelation
{
    public function handle($parent, $child)
    {
        $parent->{$this->methodName($child)}()->associate($child);
        $parent->save();
    }
}
