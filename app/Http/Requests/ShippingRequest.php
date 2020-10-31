<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
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
        // exists:settings means that the id must exist in table settings
        //'plain_value'=> 'required|nullable|numeric' means that th e value of plain_value could be null
        // and if i enter it must be a number
        return [
            'id' => 'required|exists:settings',
            'value'=> 'required',
            'plain_value'=> 'nullable|numeric',
        ];
    }
    public  function messages()
    {
        return [
            'value.required'=> 'يجب ادخال نوع وسيله التوصيل  ',

        ];

    }
}
