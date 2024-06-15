<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer'],
            'budget_id' => ['required', 'integer'],
            'name' => ['required'],
            'date' => ['required', 'date'],
            'planned' => ['required', 'integer'],
            'remaining' => ['required', 'integer'],
        ];
    }

    public function authorize (): bool
    {
        return true;
    }
}
