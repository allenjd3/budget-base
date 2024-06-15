<?php

namespace App\Models;

use Carbon\Carbon;
use Cknow\Money\Casts\MoneyIntegerCast;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    use HasFactory;

    /**
     * @var Money
     */
    public $remaining;

    /**
     * @return BelongsTo<Budget, Item>
     */
    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    /**
     * @return BelongsTo<Category, Item>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany<Transaction>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function addTransaction(string $name, Money $amount, Carbon $date): void
    {
        DB::transaction(function () use ($name, $amount, $date) {
            $this->remaining = $this->remaining->subtract($amount);
            $this->save();

            $this->transactions()->create([
                'budget_id' => $this->budget_id,
                'name' => $name,
                'amount' => $amount,
                'date' => $date,
            ]);
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts()
    {
        return [
            'date' => 'timestamp',
            'planned' => MoneyIntegerCast::class,
            'remaining' => MoneyIntegerCast::class,
        ];
    }
}
