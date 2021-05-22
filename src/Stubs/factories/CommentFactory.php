<?php

namespace Sonata\Stubs\factories;

use App\Models\GoodReceipt;
use App\Models\PurchaseOrder;
use Sonata\Stubs\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_id' => 0,
            'body' => 'foo'
        ];
    }
}
