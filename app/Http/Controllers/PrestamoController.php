<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrestamoRequest;
use App\Http\Requests\UpdatePrestamoRequest;
use App\Http\Resources\PrestamoResource;
use App\Models\Prestamo;
use Illuminate\Http\Request;


class PrestamoController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/prestamos",
     *   summary="Listar prestamos",
     *   tags={"Prestamos"},
     *   @OA\Response(
     *     response=200,
     *     description="Listado de prestamos"
     *   )
     * )
     */
    public function index()
    {
        $prestamos = Prestamo::with(['usuario', 'libro'])->paginate(10);
        return PrestamoResource::collection($prestamos);
    }

    /**
     * @OA\Post(
     *   path="/api/prestamos",
     *   summary="Crear prestamo",
     *   tags={"Prestamos"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"usuario_id","libro_id"},
     *       @OA\Property(property="usuario_id", type="integer", example=1),
     *       @OA\Property(property="libro_id", type="integer", example=1)
     *     )
     *   ),
     *   @OA\Response(response=201, description="Prestamo creado"),
     *   @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function store(StorePrestamoRequest $request)
    {
        $prestamo = Prestamo::create($request->validated());

        // Opcional: cargar relaciones para la respuesta
        $prestamo->load(['usuario', 'libro']);

        return (new PrestamoResource($prestamo))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *   path="/api/prestamos/{id}",
     *   summary="Obtener un prestamo",
     *   tags={"Prestamos"},
     *   @OA\Parameter(
     *     name="id", in="path", required=true, @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="Prestamo encontrado"),
     *   @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show(Prestamo $prestamo)
    {
        $prestamo->load(['usuario', 'libro']);
        return new PrestamoResource($prestamo);
    }

    /**
     * @OA\Put(
     *   path="/api/prestamos/{id}",
     *   summary="Actualizar prestamo",
     *   tags={"Prestamos"},
     *   @OA\Parameter(
     *     name="id", in="path", required=true, @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     @OA\JsonContent(
     *       @OA\Property(property="usuario_id", type="integer"),
     *       @OA\Property(property="libro_id", type="integer")
     *     )
     *   ),
     *   @OA\Response(response=200, description="Actualizado"),
     *   @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function update(UpdatePrestamoRequest $request, Prestamo $prestamo)
    {
        $prestamo->update($request->validated());
        $prestamo->load(['usuario', 'libro']);
        return new PrestamoResource($prestamo);
    }

    /**
     * @OA\Delete(
     *   path="/api/prestamos/{id}",
     *   summary="Eliminar prestamo",
     *   tags={"Prestamos"},
     *   @OA\Parameter(
     *     name="id", in="path", required=true, @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=204, description="Eliminado"),
     *   @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function destroy(Prestamo $prestamo)
    {
        $prestamo->delete();
        return response()->noContent(); // 204
    }
}
