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
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLibroRequest $request)
    {
        $libro = Libro::create($request->validated());
        return new LibroResource($libro);
    }

    /**
     * Display the specified resource.
     */
    public function show(Libro $libro)
    {
        return new LibroResource($libro);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Libro $libro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLibroRequest $request, Libro $libro)
    {
        $libro->update($request->validated());
        return new LibroResource($libro);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Libro $libro)
    {
        $libro->delete();
        return response()->json(['message' => 'Libro Eliminado'], 204);
    }
}
