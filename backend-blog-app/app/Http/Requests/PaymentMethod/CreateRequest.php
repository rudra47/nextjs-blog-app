<?php

namespace App\Http\Requests\PaymentMethod;

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
        $rules = [
            'name' => 'required',
            'short_name' => 'required',
            'min' => 'numeric|nullable',
            'max' => 'numeric|nullable',
            'image' => ['max:15000'],
        ];
        // conditional checking weather min and max both are exits. Then setting the rule min should be less than max
        if($this->max && $this->min){
            $rules['min'] = $rules['min'].'|lt:max';
            $rules['max'] = $rules['max'].'|gt:min';
        }
        return $rules;
    }
}
