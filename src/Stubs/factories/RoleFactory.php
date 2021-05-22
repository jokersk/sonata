<?php

namespace Sonata\Stubs\factories;

use App\Models\GoodReceipt;
use App\Models\PurchaseOrder;
use Sonata\Stubs\Models\Role;
use Sonata\Stubs\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

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
