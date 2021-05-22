<?php

namespace Sonata\Stubs\Models;

use Illuminate\Database\Eloquent\Model;
use Sonata\Stubs\factories\MediaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return MediaFactory::new();
    }
}
