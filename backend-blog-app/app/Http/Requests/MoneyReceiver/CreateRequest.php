<?php

namespace App\Http\Requests\MoneyReceiver;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'first_name'        => 'required|string',
            'initial_name'      => 'required|string',
            'country'           => 'required',
            'payment_method_id' => 'required'
        ];
    }
}
