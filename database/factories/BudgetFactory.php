<?php

namespace Database\Factories;

use App\Models\Budget;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BudgetFactory extends Factory
{
    protected $model = Budget::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'label' => $this->faker->words(rand(1, 5), true),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'user_id' => $this->faker->randomNumber(),
        ];
    }
}
