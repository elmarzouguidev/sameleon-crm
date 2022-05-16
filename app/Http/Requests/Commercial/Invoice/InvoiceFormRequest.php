<?php

namespace App\Http\Requests\Commercial\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceFormRequest extends FormRequest
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

            'client' => ['required', 'integer'],
            'company' => ['required', 'integer'],
            'ticket' => ['nullable', 'integer'],

            'tickets' => ['nullable', 'array'],

            'invoice' => ['nullable', 'numeric'], //avoir invoice

            'bl_code' => ['nullable', 'string'],
            'bc_code' => ['nullable', 'string'],

            'invoice_date' => ['required', 'date', 'date_format:Y-m-d'],
            'due_date' => ['required', 'date', 'date_format:Y-m-d'],
            'payment_mode' => ['required', 'string'],

            'admin_notes' => ['nullable', 'string'],
           // 'client_notes' => ['nullable', 'string'],
            'condition_general' => ['nullable', 'string'],

            'articles' => ['required', 'array'],
            'articles.*.designation' => ['required', 'string'],
            'articles.*.description' => ['nullable', 'string'],
            'articles.*.quantity' => ['required', 'integer'],
            'articles.*.prix_unitaire' => ['required', 'numeric','digits_between:1,20'],
            //'articles.*.montant_ht' => ['nullable', 'numeric'],
            'estimated' => ['nullable', 'uuid']

        ];
    }
}
