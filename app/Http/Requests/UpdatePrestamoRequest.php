<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrestamoRequest extends FormRequest
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
            'usuario_id'                => 'sometimes|integer|exists:usuarios,usuario_id',
            'libro_id'                  => 'sometimes|integer|exists:libros,libro_id',
            'fecha_prestamo'            => 'sometimes|date',
            'fecha_devolucion_esperada' => 'sometimes|date|after_or_equal:fecha_prestamo',
            'fecha_devolucion_real'     => 'sometimes|nullable|date|after_or_equal:fecha_prestamo',
            'estado'                    => 'sometimes|in:activo,devuelto,vencido',
        ];
    }

    public function messages(): array
    {
        return [
            'usuario_id.exists' => 'El usuario especificado no existe.',
            'libro_id.exists'   => 'El libro especificado no existe.',
            'estado.in'         => 'Estado inválido. Use: activo, devuelto o vencido.',
        ];
    }
}
