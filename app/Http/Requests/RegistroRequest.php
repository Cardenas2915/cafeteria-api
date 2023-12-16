<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

//se estancia la libreria de password y se renombra a passwordRules
use Illuminate\Validation\Rules\Password as PasswordRules;

class RegistroRequest extends FormRequest
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
            //se colocan las validacion para registrar usuarios y se mandan al controlador
            'name' => ['required','string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                //*utilizamos la libreria de password y validamos que la libreria tenga minimo 8 caracteres/letras/simbolos y numeros
                PasswordRules::min(8)->letters()->symbols()->numbers(),
            ]

        ];
    }

    public function messages()
    {
        return [
            'name' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email no es valido',
            'email.unique' => 'El usuario ya esta registrado',
            'password' => 'El password debe contener almenos 8 caracteres. un simbolo y un numero'
        ];
    }
}
