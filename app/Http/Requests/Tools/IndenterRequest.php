<?php

namespace App\Http\Requests\Tools;

use Illuminate\Foundation\Http\FormRequest;

class IndenterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if (! $this->isMethod('POST')) {
            return [];
        }

        return [
            'content' => ['required', 'string'],
            'line_width' => ['required', 'integer', 'min:1', 'max:500'],
            'prefix' => ['nullable', 'string', 'max:10'],
            'remove_extra_newlines' => ['sometimes', 'boolean'],
        ];
    }
}
