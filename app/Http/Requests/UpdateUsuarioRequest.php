<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
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
        $usuarioModel = $this->route('usuario');
        $usuarioId = is_object($usuarioModel) ? $usuarioModel->usuario_id : $usuarioModel;

        return [
            'nombre'   => 'sometimes|required|string|max:100',
            'apellido' => 'sometimes|required|string|max:100',
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:100',
                Rule::unique('usuarios', 'email')->ignore($usuarioId, 'usuario_id'),
            ],
            'password' => 'sometimes|required|string|min:6',
            'tipo'     => 'sometimes|in:estudiante,docente,publico',
        ];
    }
}
