<?php

namespace App\Http\Requests\Application\Ticket;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketFormRequest extends FormRequest
{

    //protected $redirectRoute = 'dashboard';
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
            'article' => 'required|string',
            'description' => 'required|string',
            'photo' => ['required', 'file', 'mimes:png,jpg,jpeg', 'max:2048'],
            'client' => 'required|integer',
            'ticket_retoure' => ['nullable', 'integer'],
            'is_retour' => ['nullable', Rule::in([1, '1', true, 'on', 'yes', 'oui', '0', 'no', 'non', false])]
        ];
    }

    public function messages()
    {
        return [
            'photo.required' => "You must use the 'Choose file' button to select which file you wish to upload",
            'photo.max' => "Maximum file size to upload is 2MB (2048 KB)."
        ];
    }
}
