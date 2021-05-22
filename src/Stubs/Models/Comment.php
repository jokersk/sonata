<?php
namespace Sonata\Stubs\Models;

use Illuminate\Database\Eloquent\Model;
use Sonata\Stubs\factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected static function newFactory() {
        return CommentFactory::new();
    }
}
