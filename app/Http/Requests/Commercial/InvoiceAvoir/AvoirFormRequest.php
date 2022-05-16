<?php

namespace App\Http\Requests\Commercial\InvoiceAvoir;

use Illuminate\Foundation\Http\FormRequest;

class AvoirFormRequest extends FormRequest
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

            'client' => ['nullable', 'integer'],
            'company' => ['required', 'integer'],
            'ticket' => ['nullable', 'integer'],

            'invoice_number' => ['required', 'numeric'], //avoir invoice

            'invoice_date' => ['required', 'date', 'date_format:Y-m-d'],
            //'due_date' => ['required', 'date', 'date_format:Y-m-d'],

            'admin_notes' => ['nullable', 'string'],
            'payment_mode' => ['required', 'string'],
            'condition_general' => ['nullable', 'string'],

            'articles' => ['required', 'array'],
            'articles.*.designation' => ['required', 'string'],
            'articles.*.description' => ['nullable', 'string'],
            'articles.*.quantity' => ['required', 'integer'],
            'articles.*.prix_unitaire' => ['required', 'numeric','digits_between:1,20'],
            //'articles.*.montant_ht' => ['nullable', 'numeric'],
        ];
    }
}
