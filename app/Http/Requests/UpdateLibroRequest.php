<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLibroRequest extends FormRequest
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
            'titulo'                => 'sometimes|required|string|max:255',
            'autor'                 => 'sometimes|required|string|max:255',
            'isbn'                  => [
                'sometimes',
                'required',
                'string',
                'max:32',
                Rule::unique('libros', 'isbn')->ignore($this->libro, 'libro_id')
            ],
            'anio_publicacion'      => 'sometimes|nullable|integer|between:1500,' . date('Y'),
            'editorial'             => 'sometimes|nullable|string|max:255',
            'categoria'             => 'sometimes|nullable|string|max:255',
            'cantidad_ejemplares'   => 'sometimes|required|integer|min:0',
            'ejemplares_disponibles' => 'sometimes|required|integer|min:0',
            'estado'                => 'sometimes|required|in:disponible,agotado,inactivo',
            'imagen_url'            => 'sometimes|nullable|string|max:500',
        ];
    }
}
