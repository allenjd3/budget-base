<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition (): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'category_id' => $this->faker->randomNumber(),
            'budget_id' => $this->faker->randomNumber(),
            'name' => $this->faker->words(rand(2, 5), true),
            'date' => Carbon::now(),
            'planned' => rand(5000, 50000),
            'remaining' => rand(5000, 50000),
        ];
    }
}
