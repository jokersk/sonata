<?php

namespace Sonata\Stubs\Models;

use Illuminate\Database\Eloquent\Model;
use Sonata\Stubs\factories\RoleFactory;
use Sonata\Stubs\factories\MediaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected static function newFactory()
    {
        return RoleFactory::new();
    }
}
