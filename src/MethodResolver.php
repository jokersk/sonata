<?php

namespace Sonata;

use ReflectionMethod;
use Illuminate\Support\Str;
use Sonata\Relations\HasOne;
use Sonata\Relations\HasMany;
use Sonata\Relations\MorphOne;
use Sonata\Relations\BelongsTo;
use Sonata\Relations\MorphMany;
use Sonata\Relations\MorphToMany;
use Sonata\Relations\BelongsToMany;
use Sonata\Relations\AbstractRelation;
use Illuminate\Database\Eloquent\Model;

class MethodResolver
{
    protected $parent;
    protected $child;

    protected $reflection;

    /**
     * Undocumented function
     *
     * @param [type] $parent
     * @param [type] $child
     * @return AbstractRelation
     */
    public function resolve($parent, $child): AbstractRelation
    {
        $this->parent = $parent;
        $this->reflection = new \ReflectionClass($this->parent);
        $baseName = Str::camel(class_basename($child));
        $method = $this->tryMethodName($baseName);
        $body = $this->getFunctionContent($method);
        foreach ($this->maps() as $key => $value) {
            if (Str::contains($body, $key)) {
                return $this->maps()[$key];
            }
        }

        $parentClass = get_class($parent);
        throw new \Exception("Can't find any relation with {$parentClass} and {$child}", 1);
    }

    /**
     * Undocumented function
     *
     * @param [type] $baseName
     * @return ReflectionMethod
     */
    public function tryMethodName($baseName): ReflectionMethod
    {
        if ($by = Sonata::$by) {
            return $this->reflection->getMethod($by);
        }

        if ($this->reflection->hasMethod($baseName)) {
            return $this->reflection->getMethod($baseName);
        }

        $plural = Plural::with($baseName);

        if ($this->reflection->hasMethod($plural)) {
            return $this->reflection->getMethod($plural);
        }


        $parentClass = get_class($this->parent);
        throw new \Exception("Can not find method {$baseName} or {$plural} in {$parentClass}", 1);

    }

    /**
     * Undocumented function
     *
     * @param [type] $method
     * @return string
     */
    protected function getFunctionContent($method): string
    {
        $source = file($method->getFileName());
        $start_line = $method->getStartLine() - 1;
        $end_line = $method->getEndLine();
        $length = $end_line - $start_line;
        return implode("", array_slice($source, $start_line, $length));
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function maps(): array
    {
        return [
            'belongsToMany' => new BelongsToMany,
            'belongsTo' => new BelongsTo,
            'hasMany' => new HasMany,
            'morphMany' => new MorphMany,
            'morphToMany' => new MorphToMany,
            'hasOne' => new HasOne,
            'morphOne' => new MorphOne
        ];
    }
}
