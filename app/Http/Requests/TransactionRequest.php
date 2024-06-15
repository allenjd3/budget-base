<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules (): array
    {
        return [
            'item_id' => ['required', 'integer'],
            'budget_id' => ['required', 'integer'],
            'name' => ['required'],
            'amount' => ['required', 'integer'],
            'date' => ['required', 'date'],
        ];
    }

    public function authorize (): bool
    {
        return true;
    }
}
