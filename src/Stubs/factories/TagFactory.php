<?php

namespace Sonata\Stubs\factories;

use App\Models\GoodReceipt;
use Sonata\Stubs\Models\Tag;
use App\Models\PurchaseOrder;
use Sonata\Stubs\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name
        ];
    }
}
