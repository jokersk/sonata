<?php
namespace Sonata\Relations;

use Illuminate\Support\Str;
use Sonata\Sonata;

abstract class AbstractRelation
{
    abstract public function handle($parent, $child);

    public function getMethodName($child)
    {
        return Str::camel(class_basename($child));
    }

    public function methodName($child) {
        if ($by = Sonata::$by) {
            Sonata::$by = null;
            return $by;
        }
        return $this->getMethodName($child);
    }
}
