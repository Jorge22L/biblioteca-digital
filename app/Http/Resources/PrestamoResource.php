<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrestamoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                          => $this->prestamo_id,
            'usuario_id'                  => $this->usuario_id,
            'libro_id'                    => $this->libro_id,
            'fecha_prestamo'              => $this->fecha_prestamo,
            'fecha_devolucion_esperada'   => $this->fecha_devolucion_esperada,
            'fecha_devolucion_real'       => $this->fecha_devolucion_real,
            'estado'                      => $this->estado,
            // Si quieres incluir info relacionada (solo cuando se carga con with()):
            'usuario' => $this->whenLoaded('usuario', function () {
                return [
                    'id'       => $this->usuario->usuario_id,
                    'nombre'   => $this->usuario->nombre,
                    'apellido' => $this->usuario->apellido,
                    'email'    => $this->usuario->email,
                    'tipo'     => $this->usuario->tipo,
                ];
            }),
            'libro' => $this->whenLoaded('libro', function () {
                return [
                    'id'     => $this->libro->libro_id,
                    'titulo' => $this->libro->titulo,
                    'autor'  => $this->libro->autor,
                    'isbn'   => $this->libro->isbn,
                ];
            }),
        ];
    }
}
