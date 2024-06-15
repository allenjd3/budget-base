<?php

namespace App\Models;

use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'amount',
        'date',
        'name',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts ()
    {
        return [
            'date' => 'timestamp',
            'amount' => MoneyIntegerCast::class,
        ];
    }

    /**
     * @return BelongsTo<Budget, Transaction>
     */
    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    /**
     * @return BelongsTo<Item, Transaction>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
