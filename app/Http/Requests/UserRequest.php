<?php

namespace App\Http\Requests;

use App\Http\Traits\FieldValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'username' => 'required|unique:users,username,' . ($this->user->id ?? "NULL"),
            'password'  => ['confirmed', 'min:3', new RequiredIf($this->isMethod('POST')),],
        ];
    }
}
