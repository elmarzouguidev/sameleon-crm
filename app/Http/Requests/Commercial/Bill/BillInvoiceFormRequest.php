<?php

namespace App\Http\Requests\Commercial\Bill;

use Illuminate\Foundation\Http\FormRequest;

class BillInvoiceFormRequest extends FormRequest
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
            //'invoice' => ['required', 'uuid']
        ];
    }
}
