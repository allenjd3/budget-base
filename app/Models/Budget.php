<?php

namespace App\Models;

use Cknow\Money\Casts\MoneyIntegerCast;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * @property Money $remaining
 */
class Budget extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo<User, Budget>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<Item>
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * @return HasMany<Transaction>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @param array{
     *     name: string,
     *     remaining: integer,
     *     planned: integer,
     *     budget_id: integer,
     *     category_id: integer|null
     *     } $itemValues
     * @param array{
     *     name: string,
     *     user_id: integer,
     * }|array<empty> $category
     */
    public function createItem(array $itemValues, array $category = []): Item
    {
        $item = new Item;
        DB::transaction(function () use (&$item, $itemValues, $category) {
            $this->remaining = $this->remaining->subtract(Money::USD(data_get($itemValues, 'planned')));
            $this->save();

            $categoryId = data_get($itemValues, 'category_id');

            if (count($category)) {
                $categoryId = Category::create($category);
            }

            $item = $this->items()->create(array_merge($itemValues, ['category_id' => $categoryId]));
        });

        return $item;
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'timestamp',
            'end_date' => 'timestamp',
            'planned' => MoneyIntegerCast::class,
            'remaining' => MoneyIntegerCast::class,
        ];
    }
}
