<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition (): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'item_id' => $this->faker->randomNumber(),
            'budget_id' => $this->faker->randomNumber(),
            'name' => $this->faker->words(rand(2, 5), true),
            'amount' => $this->faker->randomNumber(),
            'date' => Carbon::now(),
        ];
    }
}
