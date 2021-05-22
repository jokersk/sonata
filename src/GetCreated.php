<?php

namespace Sonata;

use Illuminate\Support\Arr;

class GetCreated
{
    protected $sonata;
    protected $created;

    public function __construct(Sonata $sonata)
    {
        $this->sonata = $sonata;
        $this->created = $this->sonata->created;
    }

    public function reset()
    {
        $this->sonata->reset();
    }

    public function handle($keys)
    {

        if (is_null($keys)) {
            return $this->getWithNotPayload();
        }

        if (is_array($keys)) {
            return $this->getByArray($keys);
        }

        if (count(Arr::flatten($this->created[$keys])) === 1) {
            $result = Arr::first(Arr::flatten($this->created[$keys]));
            $this->reset();
            return $result;
        }

        $result = $this->created[$keys];
        $this->reset();

        return $result;
    }

    protected function getCreatedByKey($key)
    {
        if (count($this->created[$key]) === 1) {
            return Arr::first($this->created[$key]);
        }
        return $this->created[$key];
    }

    protected function getWithNotPayload()
    {
        if (count(Arr::flatten($this->created)) === 1) {
            $result = Arr::first(Arr::flatten($this->created));
            $this->reset();
            return $result;
        }

        $result = [];
        foreach ($this->created as $key => $value) {
            $result[] = $this->getCreatedByKey($key);
        }
        $this->reset();
        return $result;
    }

    protected function getByArray($keys)
    {
        $result = [];
        foreach ($keys as $key) {
            $result[] = $this->getCreatedByKey($key);
        }
        $this->reset();
        return $result;
    }
}
