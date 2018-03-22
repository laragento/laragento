<?php

namespace Laragento\CustomerImportExport\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportCustomerRequest extends FormRequest
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
            //'email' => 'unique:customer_entity',
            'website_id' => 'required|integer|max:1',
            'email' => 'required|email',
            'group_id' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
        ];
    }
}
