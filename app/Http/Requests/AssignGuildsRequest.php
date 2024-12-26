<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class AssignGuildsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'players_per_guild' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'players_per_guild.required' => __('validation.messages.required', ['field' => 'número dejogadores por guilda']),
            'players_per_guild.integer' => __('validation.messages.integer', ['field' => 'número dejogadores por guilda']),
            'players_per_guild.min' => __('validation.messages.min', ['field' => 'número dejogadores por guilda', 'min' => 1]),
        ];
    }
}
