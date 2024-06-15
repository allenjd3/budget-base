<?php

use App\Models\Item;
use Cknow\Money\Money;

test('you can add a transaction to an item', function () {
    $item = Item::factory()->state(['planned' => 20000, 'remaining' => 20000])->create();

    $item->addTransaction(name: 'My Transaction', amount: Money::USD(2000), date: now()->subDay());

    expect($item->fresh()->remaining->__toString())->toBe(Money::USD(18000)->__toString());
    $this->assertDatabaseHas('transactions', [
        'amount' => 2000,
        'name' => 'My Transaction',
    ]);
});
