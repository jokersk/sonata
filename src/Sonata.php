<?php

namespace Sonata;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
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
            //$this->create(FOO::class, ['foo' => 'bar'])
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

        //$this->create(1, foo, function() {})
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

    public function createFrom(Model $model)
    {
        $this->prevCreated = get_class($model);
        $this->created[$this->prevCreated] = collect([$model]);
        $this->createCount = 1;
        return $this;
    }

    public function with($class, $attributes = null)
    {
        if (!is_null($attributes)) {
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

    public function get($keys = null)
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

    public static function createMock($path, $result) {
        $paths = explode("->", $path);
        $class = new MockClass;
        $first = array_shift($paths);
        $first = new MockParse($first);
        if (count($paths) == 0) {
            $class->attributes[$first->toString()] = $result;
        } else {
            $class->attributes[$first->toString()] = static::createMock(implode('->', $paths), $result);
        }
        return $class;
    }
}
class MockParse {
    protected $string;
    protected $match;
    public function __construct(String $string) {
        $this->string = $string;
        preg_match('/(.*)\(.*\)/', $this->string, $match);
        $this->match = $match;
    }
    public function toString() {
        return $this->isFunc()? $this->funcName() : $this->string;
    }
    public function funcName() {
        return $this->match[1];
    }
    public function isFunc()
    {
        return $this->match[0]?? false;
    }
}
class MockClass {
    public $attributes = [];
    public function __call($name, $arguments)
    {
        return $this->attributes[$name];
    }
    public function __get($name)
    {
        return $this->attributes[$name];
    }
}
