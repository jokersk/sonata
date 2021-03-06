<?php
namespace Sonata\Stubs\Models;

use App\Models\User;
use Sonata\Stubs\Models\Tag;
use Sonata\Stubs\Models\Media;
use Sonata\Stubs\Models\Teaser;
use Sonata\Stubs\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Sonata\Stubs\factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body'];

    protected static function newFactory() {
        return PostFactory::new();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medias()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }


    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function activeTags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function teaser() {
        return $this->hasOne(Teaser::class);
    }
}
