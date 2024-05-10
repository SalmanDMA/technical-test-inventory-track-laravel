<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'availability' => 'available',
            'image' => null,
            'quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
