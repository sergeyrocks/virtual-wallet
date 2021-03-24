<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class WalletStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'   => 'required|regex:/^([A-я _.\-0-9])+$/',
            'balance' => 'required|numeric',
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'title.required'  => 'A title is required',
            'title.regex'     => 'The title format is invalid. Allowed uppercase and lowercase letters, number and symbols: ". -_"',
            'balance.numeric' => 'The balance must be a number. Use "." for decimals.',
        ];
    }
}
