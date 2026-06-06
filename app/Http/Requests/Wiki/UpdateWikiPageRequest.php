<?php

namespace App\Http\Requests\Wiki;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWikiPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPrivilege('SUPERUSER') ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'alt_title' => ['nullable', 'string', 'max:64'],
            'content' => ['nullable', 'string'],
        ];
    }
}
