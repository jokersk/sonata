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
    public static $by;

    public function reset()
    {
        $this->created = [];
        $this->prevCreated = '';
        $this->createCount = 1;
    }

    public function create($count = 1, ?string $class = null, ?callable $callback = null)
    {
        if (is_string($count)) {
            $class = $count;
            $count = 1;
        }


        $this->created[$class] = Factory::factory($class, $count);

        if ($callback) {
            $callback($this->created[$class]);
        }
        $this->prevCreated = $class;
        $this->createCount = $count;
        return $this;
    }

    public function save($class)
    {
        return $this->create($this->createCount, $class, function ($children) use ($class) {
            foreach ($this->created[$this->prevCreated] as $key => $value) {
                $relation = (new MethodResolver)->resolve($value, $class);
                $relation->handle($value, $children[$key]);
            }
        });
    }

    public function with($class)
    {
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
}
