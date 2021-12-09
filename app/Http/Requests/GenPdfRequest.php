<?php

namespace App\Http\Requests;

use App\Rules\TicketOwner;
use Illuminate\Foundation\Http\FormRequest;

class GenPdfRequest extends FormRequest
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
            'ticket_id' => ['required', 'exists:tickets,id',new TicketOwner()],
        ];
    }
}
