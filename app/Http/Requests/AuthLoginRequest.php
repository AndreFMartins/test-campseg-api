<?php

namespace App\Http\Requests;

use App\Http\Traits\FieldValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{

    use FieldValidationTrait;
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
            'username' => 'required',
            'password'  => 'required',
        ];
    }
}
