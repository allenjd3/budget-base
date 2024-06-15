<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()
            ->count(10)
            ->create();

        User::all()
            ->each(function ($user) {
                Budget::factory()->for($user)->count(5)->create();
                Category::factory()->for($user)->count(10)->create();

                $user->budgets
                    ->each(function ($budget) use ($user) {
                        $user->categories->each(function ($category) use ($budget) {
                            $items = Item::factory()
                                ->for($budget)
                                ->for($category)
                                ->count(8)
                                ->create();

                            $transaction = Transaction::factory()->make();
                            $items->each(function ($item) use ($budget, $transaction) {
                                for ($i = 0; $i < rand(3, 10); $i++) {
                                    $item->addTransaction(name: $transaction->name, amount: $transaction->amount, date: Carbon::createFromTimestamp($transaction->date));
                                }
                            });
                        });
                    });
            });


    }
}
