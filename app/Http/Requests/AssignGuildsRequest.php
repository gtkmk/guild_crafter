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
            'playersPerGuild' => [
                'required',
                'integer',
                'min:3',
                'max:100',
            ],
        ];
    }

    public function messages(): array
    {
        return array_merge(
            Lang::get('validation.messages'),
            [
                'playersPerGuild.required' => __('validation.messages.required', ['field' => 'jogadores por guilda']),
                'playersPerGuild.integer' => __('validation.messages.integer', ['field' => 'jogadores por guilda']),
                'playersPerGuild.min' => __('validation.messages.minimum_players_per_guild'),
                'playersPerGuild.max' => __('validation.messages.max', ['field' => 'jogadores por guilda', 'max' => 100]),
            ]
        );
    }
}