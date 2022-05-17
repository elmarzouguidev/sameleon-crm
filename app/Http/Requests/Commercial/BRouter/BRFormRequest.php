<?php

declare(strict_types=1);

namespace App\Http\Requests\Commercial\BRouter;

use Illuminate\Foundation\Http\FormRequest;

class BRFormRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
