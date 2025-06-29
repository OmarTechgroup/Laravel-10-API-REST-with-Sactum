<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class logUserRequests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //

            'email'=> 'required|email|exists:users|email',
            'password'=>'required'
        ];
    }

     public function failedValidation(Validator $validator){

    return (


        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => true,
            'message'=> 'Erreur de validation',
            'errorList'=> $validator->errors()
        ]))

        
        );
   }
}
