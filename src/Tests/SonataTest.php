<?php

namespace Sonata\Tests;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Arr;
use Sonata\Stubs\Models\Tag;
use Sonata\Stubs\Models\Post;
use Sonata\Stubs\Models\Media;
use Sonata\Stubs\Models\Comment;
use Sonata\Traits\LetsPlaySonata;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Sonata\Stubs\Models\Role;

class SonataTest extends TestCase
{
    use LetsPlaySonata, RefreshDatabase;

    /** @test */
    public function can_create_model()
    {
        $this->create(Post::class);

        $this->assertDatabaseCount('posts', 1);
    }

    /** @test */
    public function can_get_created_models()
    {
        $post = $this->create(Post::class)->getCreated();

        $this->assertTrue($post instanceof Post);
    }

    /** @test */
    public function can_get_child()
    {
        $this->create(Post::class)->with(Comment::class);

        $this->assertDatabaseCount('comments', 1);
    }

    /** @test */
    public function expect_exception_when_model_didnt_default_relations()
    {
        $this->expectException(\Exception::class);
        $this->create(Post::class)->with(Post::class);
    }

    /** @test */
    public function can_create_multiple_models()
    {
        $this->create(2, Post::class)->with(Comment::class);

        $this->assertDatabaseCount('posts', 2);
        $this->assertDatabaseCount('comments', 2);
    }

    /** @test */
    public function can_get_first_model()
    {
        [$post, $comment] = $this->create(Post::class)->with(Comment::class)->getCreated([Post::class, Comment::class]);

        $this->assertTrue($post instanceof Post);
        $this->assertTrue($comment instanceof Comment);
    }

    /** @test */
    public function can_get_created_with_differenc_order()
    {
        [$comment, $post] = $this->create(Post::class)->with(Comment::class)->getCreated([Comment::class, Post::class]);

        $this->assertTrue($post instanceof Post);
        $this->assertTrue($comment instanceof Comment);
    }

    /** @test */
    public function can_get_multiple_created_models()
    {
        [$posts, $comments] = $this->create(2, Post::class)->with(Comment::class)->getCreated(Post::class, Comment::class);

        $this->assertTrue(Arr::first($posts) instanceof Post);
        $this->assertTrue(Arr::first($comments) instanceof Comment);
    }

    /** @test */
    public function can_get_multiple_created_models_by_array()
    {
        [$posts, $comments] = $this->create(2, Post::class)->with(Comment::class)->getCreated([Post::class, Comment::class]);

        $this->assertTrue(Arr::first($posts) instanceof Post);
        $this->assertTrue(Arr::first($comments) instanceof Comment);
    }

    /** @test */
    public function will_get_all_created_and_keys_is_empty()
    {
        [$posts, $comments] = $this->create(2, Post::class)->with(Comment::class)->getCreated();

        $this->assertCount(2, $comments);
        $this->assertCount(2, $posts);
        $this->assertTrue(Arr::first($posts) instanceof Post);
        $this->assertTrue(Arr::first($comments) instanceof Comment);

        [$post, $comments] = $this->create(Post::class)->with(Comment::class)->getCreated();
        $this->assertTrue($post instanceof Post);
    }

    /** @test */
    public function can_save_with_belongs_to_methods()
    {
        [$post, $user] = $this->create(Post::class)->with(User::class)->getCreated();
        $this->assertEquals(
            $user->id,
            $post->user->id
        );
    }


    /** @test */
    public function can_save_with_belongs_to_many_methods()
    {
        [$post, $media] = $this->create(Post::class)->with(Media::class)->getCreated();

        $this->assertEquals(
            $post->medias->first()->id,
            $media->id
        );
    }

    /** @test */
    public function can_handle_morphToMany() {
        [$post, $tag] = $this->create(Post::class)->with(Tag::class)->getCreated();

        $this->assertEquals(
            $post->tags->first()->id,
            $tag->id
        );
    }

    /** @test */
    public function can_defind_function_name() {
        [$post, $tag] = $this->create(Post::class)->by('activeTags')->with(Tag::class)->getCreated();

        $this->assertEquals(
            $post->activeTags->first()->id,
            $tag->id
        );
    }

    /** @test */
    public function can_handle_belongsToMany_relation() {
        [$user, $role] = $this->create(User::class)->with(Role::class)->GetCreated();

        $this->assertEquals(
            $role->name,
            $user->roles->first()->name
        );
    }
}
