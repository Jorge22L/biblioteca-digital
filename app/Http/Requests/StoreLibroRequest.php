<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLibroRequest extends FormRequest
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
            'titulo'                => 'required|string|max:255',
            'autor'                 => 'required|string|max:255',
            'isbn'                  => 'required|string|max:32|unique:libros,isbn',
            'anio_publicacion'      => 'nullable|integer|between:1500,' . date('Y'),
            'editorial'             => 'nullable|string|max:255',
            'categoria'             => 'nullable|string|max:255',
            'cantidad_ejemplares'   => 'required|integer|min:0',
            'ejemplares_disponibles' => 'required|integer|min:0',
            'estado'                => 'in:disponible,agotado,inactivo',
            'imagen_url'            => 'nullable|string|max:500',
        ];
    }
}
