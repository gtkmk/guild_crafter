<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class StorePlayerRequest extends FormRequest
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
                'regex:/^[a-zA-ZÀ-ÿ\s]+$/',
            ],
            'class' => [
                'required',
                'in:warrior,mage,archer,cleric',
            ],
            'xp' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],
        ];
    }

    // public function messages(): array
    // {
    //     return array_merge(
    //         Lang::get('validation.messages'),
    //         [
    //             'name.regex' => __('validation.regex', ['field' => 'nome']),
    //             'name.min' => __('validation.min', ['field' => 'nome', 'min' => 3]),
    //             'name.max' => __('validation.max', ['field' => 'nome', 'max' => 100]),
    //             'class.in' => __('validation.in', ['field' => 'classe']),
    //             'xp.integer' => __('validation.integer', ['field' => 'experiência']),
    //         ]
    //     );
    // }

    public function messages(): array
    {
        return array_merge(
            Lang::get('validation.messages'), // Mensagens genéricas do arquivo de tradução
            [
                'name.regex' => __('validation.messages.regex', ['field' => 'nome']),
                'name.min' => __('validation.messages.min', ['field' => 'nome', 'min' => 3]),
                'name.max' => __('validation.messages.max', ['field' => 'nome', 'max' => 100]),
                'class.in' => __('validation.messages.in', ['field' => 'classe']),
                'xp.integer' => __('validation.messages.integer', ['field' => 'experiência']),
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
