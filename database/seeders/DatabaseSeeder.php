<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                            Item::factory()
                                ->for($budget)
                                ->for($category)
                                ->has(Transaction::factory()->for($budget)->count(10))
                                ->count(8)
                                ->create();
                        });
                    });
            });


    }
}
