<?php

namespace Laragento\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddress extends FormRequest
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
            'parent_id' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'country_id' => 'required|max:2',
        ];
    }
}
