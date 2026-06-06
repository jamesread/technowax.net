<?php

namespace App\Http\Requests\Tools;

use Illuminate\Foundation\Http\FormRequest;

class TeamMakerRequest extends FormRequest
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
            'team_list' => ['required', 'string'],
            'team_count' => ['required', 'integer', 'min:2', 'max:100'],
        ];
    }
}
