<?php
namespace Sonata\Tests;

use Tests\TestCase;
use Sonata\Stubs\Models\Post;
use Sonata\Traits\LetsPlaySonata;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Sonata\Stubs\Models\Comment;

class AttributesTest extends TestCase
{
    use LetsPlaySonata, RefreshDatabase;

    /** @test */
    public function can_input_some_attributes() {
        $this->create(Post::class, [
            'title' => 'abc',
            'body' => 'hi'
        ]);

        $this->assertDatabaseHas('posts', [
            'body' => 'hi'
        ]);
    }

    /** @test */
    public function can_set_attributes() {
        $this->set([
            'title' => 'abc',
            'body' => 'hi'
        ])->create(Post::class);

        $this->assertDatabaseHas('posts', [
            'body' => 'hi'
        ]);
    }

    /** @test */
    public function can_set_child_attributes() {
        $this->create(Post::class)->set(['body' => 'hhh'])->with(Comment::class);

        $this->assertDatabaseHas('comments', [
            'body' => 'hhh'
        ]);
    }
}
