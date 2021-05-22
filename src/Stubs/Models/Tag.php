<?php
namespace Sonata\Stubs\Models;

use Sonata\Stubs\factories\TagFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model {
    use HasFactory;

    public $timestamps = false;

    protected static function newFactory() {
        return TagFactory::new();
    }
}
