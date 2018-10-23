<?php

namespace Laragento\CatalogImportExport\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportSimpleProductErrorRequest extends FormRequest
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
            //'website_id' => 'required|integer|max:1',
            'sku' => 'required',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
            'tax' => 'required|numeric',
        ];
    }
}
