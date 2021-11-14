<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'plate' => $this->plate1 . '-' . $this->plate2 . '-' .$this->plate3 . '-' .$this->plate4,
        ]);
    }
}
