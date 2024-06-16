<?php

use App\Models\Budget;
use App\Models\Category;
use App\Models\User;
use Cknow\Money\Money;

test('it can create an item', function () {
    $budget = Budget::factory()
        ->has(User::factory(), 'user')
        ->state([
            'planned' => 2000_00,
            'remaining' => 2000_00,
        ])
        ->create();

    $category = Category::factory()->for($budget->user)->create();

    $item = $budget->createItem(itemValues: ['remaining' => 200_00, 'planned' => 200_00, 'name' => 'My First Item', 'budget_id' => $budget->id, 'category_id' => $category->id]);

    expect($budget->remaining->__toString())->toBe(Money::USD(1800_00)->__toString());

    $this->assertDatabaseHas('items', [
        'name' => $item->name,
    ]);
});
