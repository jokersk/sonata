<?php

namespace Sonata\Stubs\factories;

use App\Models\GoodReceipt;
use App\Models\PurchaseOrder;
use Sonata\Stubs\Models\Media;
use Sonata\Stubs\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => '',
            'mediaable_id' => 0,
            'mediaable_type' => ''
        ];
    }
}
