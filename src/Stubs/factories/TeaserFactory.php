<?php

namespace Sonata\Stubs\factories;

use App\Models\GoodReceipt;
use App\Models\PurchaseOrder;
use Sonata\Stubs\Models\Post;
use Sonata\Stubs\Models\Teaser;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeaserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teaser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => 'foo'
        ];
    }
}
