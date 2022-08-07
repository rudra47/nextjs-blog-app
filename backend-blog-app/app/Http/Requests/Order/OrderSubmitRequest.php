<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderSubmitRequest extends FormRequest
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
            'fname' => 'required|max:255|min:3',
            'lname' => 'required|max:255|min:3',
            'city' => 'required|max:255|min:3',
            'address' => 'required|max:255|min:3',
            'state' => 'required',
            'zip' => 'required',
            'email' => 'required|email',
            'email_confirmation' => 'required|email',
            'payment_method' => 'required',
            'phone_number' => [Rule::requiredIf($this->payment_method == 'visa'), 'nullable', 'min:8'],
            'card_number' => [Rule::requiredIf($this->payment_method == 'visa'), 'nullable', 'string'],
            'expire_month' => [Rule::requiredIf($this->payment_method == 'visa'), 'nullable', 'string'],
            'expire_year' => [Rule::requiredIf($this->payment_method == 'visa'), 'nullable', 'string'],
            'cvv' => [Rule::requiredIf($this->payment_method == 'visa'), 'nullable', 'string']
        ];
    }

    public function messages()
    {
        return [
            'fname.required' => 'This field is required.',
            'lname.required' => 'This field is required.',
            'city.required' => 'This field is required.',
            'state.required' => 'This field is required.',
            'zip.required' => 'This field is required.',
            'email.required' => 'This field is required.',
            'address.required' => 'This field is required.',
            'payment_method.required' => 'Payment method field is required.',
            'phone_number.required' => 'This field is required.',
            'card_number.required' => 'This field is required.',
            'expire_month.required' => 'This field is required.',
            'expire_year.required' => 'This field is required.',
            'cvv.required' => 'This field is required.',
        ];
    }
}
