<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
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
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email'    => 'required|email|max:100|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'tipo'     => 'sometimes|in:estudiante,docente,publico',
        ];
    }

    public function messages() : array
    {
        return [
            'email.unique' => 'El correo electrónico ya está en uso.',
            'tipo.in' => 'El tipo debe ser estudiante, docente o público.'
        ];
    }
}
