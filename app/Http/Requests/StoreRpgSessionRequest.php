<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class StoreRpgSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[\w\s\p{P}]+$/u',
                'unique:rpg_session,name'
            ],
            'campaign_date' => [
                'required',
                'date',
            ],
        ];
    }

    public function messages(): array
    {
        return array_merge(
            Lang::get('validation.messages'),
            [
                'name.regex' => __('validation.messages.regex', ['field' => 'nome da sessão']),
                'name.min' => __('validation.messages.min', ['field' => 'nome da sessão', 'min' => 3]),
                'name.max' => __('validation.messages.max', ['field' => 'nome da sessão', 'max' => 100]),
                'name.unique' => __('validation.messages.unique', ['field' => 'nome da sessão']),
                'campaign_date.date' => __('validation.messages.date', ['field' => 'data da campanha']),
            ]
        );
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'name' => trim($this->name),
        ]);
    }
}
