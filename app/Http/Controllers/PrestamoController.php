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
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestamos = Prestamo::with(['usuario', 'libro'])->paginate(10);
        return PrestamoResource::collection($prestamos);
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(Prestamo $prestamo)
    {
        $prestamo->load(['usuario', 'libro']);
        return new PrestamoResource($prestamo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrestamoRequest $request, Prestamo $prestamo)
    {
        $prestamo->update($request->validated());
        $prestamo->load(['usuario', 'libro']);
        return new PrestamoResource($prestamo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestamo $prestamo)
    {
        $prestamo->delete();
        return response()->noContent(); // 204
    }
}
