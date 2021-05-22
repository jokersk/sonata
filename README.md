# Sonata

Make your laravel test easier

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
