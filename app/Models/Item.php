<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts ()
    {
        return [
            'date' => 'timestamp',
        ];
    }

    /**
     * @return BelongsTo<Budget, Item>
     */
    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }
}
