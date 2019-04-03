<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'place_id' => 'required|unique:orders',
            'email' => 'required|email|unique:orders',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */

    public function messages()
    {
        return [
            'place_id.required' => 'Вы не указали место.',
            'place_id.unique' => 'Wasted… Пробуй другое место.',
            'email.required'  => 'Поле email обязательно для заполнения.',
            'email.email'  => 'Поле email должно быть действительным электронным адресом.',
            'email.unique' => 'Двойников не принимаем!'
        ];
    }
}
