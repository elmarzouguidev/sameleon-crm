<?php

namespace App\Http\Requests\Application\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class TicketAttachementsFormRequest extends FormRequest
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
            'photos' => 'required|array',
            'photos.*' => ['required','file','mimes:png,jpg,jpeg','max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'photos.*.required' => "You must use the 'Choose file' button to select which file you wish to upload",
            'photos.*.max' => "Maximum file size to upload is 2MB (2048 KB)."
        ];
    }
}
