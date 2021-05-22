<?php

namespace Sonata\Stubs\factories;

use App\Models\GoodReceipt;
use App\Models\PurchaseOrder;
use Sonata\Stubs\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'title' => 'foo'
        ];
    }
}
