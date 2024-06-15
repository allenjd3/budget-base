<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules (): array
    {
        return [
            'name' => ['required'],
            'user_id' => ['required', 'integer'],
        ];
    }

    public function authorize (): bool
    {
        return true;
    }
}
