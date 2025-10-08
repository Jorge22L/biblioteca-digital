<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrestamoRequest extends FormRequest
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
            'libro_id' => 'required|exists:libros,libro_id',
            'usuario_id' => 'required|exists:usuarios,usuario_id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'required|date|after:fecha_prestamo',
            'fecha_devolucion_real' => 'nullable|date|after_or_equal:fecha_devolucion',
            'estado' => 'required|in:prestado,devuelto',
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
