# Sonata

Make your laravel test easier

## Install

```
composer require jokersk/sonata
```

in your test file add ``` Sonata\Traits\LetsPlaySonata ``` trait, that it! 

## Use

```php
use Sonata\Traits\LetsPlaySonata;

class SomeTest extends TestCase
{
    use LetsPlaySonata, RefreshDatabase;
 
    ...
}
```

asume you have a model ``` \App\Models\Post ```, we can create model like this

```php
$this->create(Post::class);

```
if you want to get the created post model, you can 

```php

$post = $this->create(Post::class)->getCreated();

```

### has many

now we have a model ``` \App\Models\Comment ```, and in ``` \App\Models\Post ``` model have HasMany relation like 
```php
    public function comments()
    
    {
        return $this->hasMany(Comment::class);
    }

```
we can create the models without sonata like this
```php
$post = Post::factory()->create();
$comment = Comment::factory()->create(['post_id' => $post->id]);

```
but with sonata, you can create the models like 

```php

$this->create(Post::class)->with(Comment::class);

```
if you want to get created models you can 
```php
[$post, $comment] = $this->create(Post::class)->with(Comment::class)->getCreated([Post::class, Comment::class]);
```
or 

```php
[$post, $comment] = $this->create(Post::class)->with(Comment::class)->getCreated();

```