<?php
namespace Sonata\Stubs\Models;

use App\Models\User;
use Sonata\Stubs\Models\Tag;
use Sonata\Stubs\Models\Media;
use Sonata\Stubs\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Sonata\Stubs\factories\PostFactory;
use Sonata\Stubs\factories\TeaserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teaser extends Model
{
    use HasFactory;

    protected $fillable = ['body'];

    protected static function newFactory() {
        return TeaserFactory::new();
    }

    public function media() {
        return $this->morphOne(Media::class, 'mediaable');
    }
}
