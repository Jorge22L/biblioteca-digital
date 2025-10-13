<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibroRequest;
use App\Http\Requests\UpdateLibroRequest;
use App\Http\Resources\LibroResource;
use App\Models\Libro;
use Illuminate\Http\Request;


class LibroController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/libros",
     *   summary="Listar libros",
     *   tags={"Libros"},
     *   @OA\Response(
     *     response=200,
     *     description="Listado de libros"
     *   )
     * )
     */
    public function index(Request $request)
    {
        $query = Libro::query();

        if($s = $request->query('search')){
            $query->where('titulo', 'like', "%{$s}%")
                  ->orWhere('author','like', "%{$s}%");
        }

        return LibroResource::collection(
            $query->orderBy('libro_id','desc')->paginate(5)
        );
    }

    /**
     * @OA\Post(
     *   path="/api/libros",
     *   summary="Crear libro",
     *   tags={"Libros"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"titulo","autor"},
     *       @OA\Property(property="titulo", type="string", example="Cien años de soledad"),
     *       @OA\Property(property="autor", type="string", example="Gabriel García Márquez"),
     *       @OA\Property(property="anio", type="integer", example=1967)
     *     )
     *   ),
     *   @OA\Response(response=201, description="Libro creado"),
     *   @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function store(StoreLibroRequest $request)
    {
        $libro = Libro::create($request->validated());
        return new LibroResource($libro);
    }

    /**
     * @OA\Get(
     *   path="/api/libros/{id}",
     *   summary="Obtener un libro",
     *   tags={"Libros"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="Libro encontrado"),
     *   @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show(Libro $libro)
    {
        return new LibroResource($libro);
    }


    /**
     * @OA\Put(
     *   path="/api/libros/{id}",
     *   summary="Actualizar libro",
     *   tags={"Libros"},
     *   @OA\Parameter(
     *     name="id", in="path", required=true, @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     @OA\JsonContent(
     *       @OA\Property(property="titulo", type="string"),
     *       @OA\Property(property="autor", type="string"),
     *       @OA\Property(property="anio", type="integer")
     *     )
     *   ),
     *   @OA\Response(response=200, description="Actualizado"),
     *   @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function update(UpdateLibroRequest $request, Libro $libro)
    {
        $libro->update($request->validated());
        return new LibroResource($libro);
    }

    /**
     * @OA\Delete(
     *   path="/api/libros/{id}",
     *   summary="Eliminar libro",
     *   tags={"Libros"},
     *   @OA\Parameter(
     *     name="id", in="path", required=true, @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=204, description="Eliminado"),
     *   @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function destroy(Libro $libro)
    {
        $libro->delete();
        return response()->json(['message' => 'Libro Eliminado'], 204);
    }
}
