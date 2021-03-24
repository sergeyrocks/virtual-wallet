<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\PositiveNumber;

class TransactionStoreRequest extends FormRequest
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
        return [
            'is_incoming' => 'sometimes',
            'amount'      => ['required', 'numeric', new PositiveNumber],
            'reference'   => 'required|regex:/^([A-я :,\/.\-0-9])+$/',
            'payer'       => 'required_with:is_incoming|regex:/^([A-я :,\/.\-0-9])+$/',
            'beneficiary' => 'required_without:is_incoming|regex:/^([A-я :,\/.\-0-9])+$/',
        ];
    }
}
