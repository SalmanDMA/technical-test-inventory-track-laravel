<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Activity;
use App\Models\User;
use App\Models\Item;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $item = Item::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'type' => $this->faker->randomElement(['loan', 'return']),
            'quantity' => $this->faker->numberBetween(1, $item->quantity),
        ];
    }
}
