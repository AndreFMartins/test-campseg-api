<?php


namespace App\Http\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait FieldValidationTrait
{
    protected function failedValidation(Validator $validator)
    {
        $errors = [];
        foreach ($validator->errors()->toArray() as $key => $value) {
            $keyName = explode('.', $key);
            if (!isset($errors[$keyName[0]])) {
                $errors[$keyName[0]] = $value[0];
            }
        }
        $response = [
            "message" => "Invalid Data",
            "errors" => $errors,
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }
}