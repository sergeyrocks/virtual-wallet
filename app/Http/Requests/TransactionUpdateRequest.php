<?php

namespace App\Http\Requests;

class TransactionUpdateRequest extends TransactionStoreRequest
{

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'is_fraudulent' => $this->is_fraudulent === 'true',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'is_fraudulent' => 'required|boolean',
        ];
    }
}
