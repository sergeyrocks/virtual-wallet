<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class WalletUpdateRequest extends WalletStoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && $this->route('wallet')->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        unset($rules['balance']);
        return $rules;
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        $messages = parent::messages();
        unset($messages['balance.numeric']);
        return $messages;
    }
}
