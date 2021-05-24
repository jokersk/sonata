<?php

namespace Sonata;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

class Sonata
{
    public $created;
    protected $prevCreated;
    protected $createCount;
    protected $attributes = [];
    public static $by;

    public function reset()
    {
        $this->created = [];
        $this->prevCreated = '';
        $this->createCount = 1;
    }

    public function create()
    {
        $args = func_get_args();

        if (func_num_args() === 1 && is_string($args[0])) {
            $class = $args[0];
            $count = 1;
        }

        if (func_num_args() > 1) {
            if (is_string($args[0]) && is_array($args[1])) {
                $class = $args[0];
                $count = 1;
                $this->attributes = $args[1];
            } else {
                $count = $args[0];
                $class = $args[1];
            }
        }

        $this->created[$class] = Factory::factory($class, $count, $this->attributes);
        $this->attributes = [];

        if (func_num_args() === 3 && is_callable($args[2])) {
            $args[2]($this->created[$class]);
        }

        $this->prevCreated = $class;
        $this->createCount = $count;
        return $this;
    }

    protected function save($class)
    {
        return $this->create($this->createCount, $class, function ($children) use ($class) {
            foreach ($this->created[$this->prevCreated] as $key => $value) {
                $relation = (new MethodResolver)->resolve($value, $class);
                $relation->handle($value, $children[$key]);
            }
        });
    }

    public function with($class, $attributes = null)
    {
        if (! is_null($attributes)) {
            $this->attributes = $attributes;
        }
        return $this->save($class);
    }

    public function attach($class)
    {
        return $this->create($this->createCount, $class, function ($children) use ($class) {
            foreach ($this->created[$this->prevCreated] as $key => $value) {
                $value->{Str::camel(class_basename($class)) . 's'}()->attach($children[$key]);
            }
        });
    }

    public function getCreated($keys = null)
    {
        if (count(func_get_args()) > 1) {
            return (new GetCreated($this))->handle(func_get_args());
        }

        return (new GetCreated($this))->handle($keys);
    }

    public function created($keys = null)
    {
        return $this->getCreated($keys);
    }

    public function all()
    {
        return Arr::flatten($this->created);
    }

    public function by(string $name)
    {
        Sonata::$by = $name;
        return $this;
    }

    public function set(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }
}
