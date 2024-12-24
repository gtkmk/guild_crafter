<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            ],
            'class' => [
                'required',
                'in:Guerreiro,Mago,Arqueiro,Clérigo'
            ],
            'xp' => [
                'required',
                'integer',
                'min:1',
                'max:100'
            ],
        ];
    }
}
