<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateLibroRequest;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/usuarios",
     *   summary="Listar usuarios",
     *   tags={"Usuarios"},
     *   @OA\Response(
     *     response=200,
     *     description="Listado de usuarios"
     *   )
     * )
     */
    public function index()
    {
        return UsuarioResource::collection(Usuario::paginate(10));
    }

    /**
     * @OA\Post(
     *   path="/api/login",
     *   tags={"Autenticación"},
     *   summary="Iniciar sesión y obtener token",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *       @OA\Property(property="password", type="string", format="password", example="secret")
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Token emitido",
     *     @OA\JsonContent(
     *       @OA\Property(property="token", type="string", example="1|xxxxxxxxxxxxxxxx")
     *     )
     *   ),
     *   @OA\Response(response=401, description="Credenciales inválidas")
     * )
     */
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if(!$usuario || !Hash::check($request->password, $usuario->password)){
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        $token = $usuario->createToken('api', ['*'], now()->addWeek())->plainTextToken;

        return response()->json([
            'token' => $token,
            'usuario' => [
                'usuario_id' => $usuario->usuario_id,
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'email' => $usuario->email,
                'tipo' => $usuario->tipo,
            ]
        ]);
    }

    /**
     * @OA\Post(
     *   path="/api/logout",
     *   tags={"Auth"},
     *   summary="Cerrar sesión (revocar token actual)",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(response=204, description="Token revocado")
     * )
     */
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }

    /**
     * @OA\Get(
     *   path="/api/me",
     *   tags={"Auth"},
     *   summary="Obtener usuario autenticado",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="Usuario autenticado",
     *     @OA\JsonContent(
     *       @OA\Property(property="usuario_id", type="integer"),
     *       @OA\Property(property="nombre", type="string"),
     *       @OA\Property(property="apellido", type="string"),
     *       @OA\Property(property="email", type="string"),
     *       @OA\Property(property="tipo", type="string")
     *     )
     *   )
     * )
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * @OA\Post(
     *   path="/api/usuarios",
     *   summary="Crear usuario",
     *   tags={"Usuarios"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"nombre","apellido","email","password","tipo"},
     *       @OA\Property(property="nombre", type="string", example="Juan"),
     *       @OA\Property(property="apellido", type="string", example="Perez"),
     *       @OA\Property(property="email", type="string", example="juan.perez@example.com"),
     *       @OA\Property(property="password", type="string", example="password123"),
     *       @OA\Property(property="tipo", type="string", example="usuario")
     *     )
     *   ),
     *   @OA\Response(response=201, description="Usuario creado"),
     *   @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function store(StoreUsuarioRequest $request)
    {
        $data = $request->validated();

        $usuario = Usuario::create($data);

        return (new UsuarioResource($usuario))
        ->response()
        ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *   path="/api/usuarios/{id}",
     *   summary="Obtener un usuario",
     *   tags={"Usuarios"},
     *   @OA\Parameter(
     *     name="id", in="path", required=true, @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="Usuario encontrado"),
     *   @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show(Usuario $usuario)
    {
        return new UsuarioResource($usuario);
    }

    /**
     * @OA\Put(
     *   path="/api/usuarios/{id}",
     *   summary="Actualizar usuario",
     *   tags={"Usuarios"},
     *   @OA\Parameter(
     *     name="id", in="path", required=true, @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     @OA\JsonContent(
     *       @OA\Property(property="nombre", type="string"),
     *       @OA\Property(property="apellido", type="string"),
     *       @OA\Property(property="email", type="string"),
     *       @OA\Property(property="password", type="string"),
     *       @OA\Property(property="tipo", type="string")
     *     )
     *   ),
     *   @OA\Response(response=200, description="Actualizado"),
     *   @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function update(UpdateLibroRequest $request, Usuario $usuario)
    {
        $data = $request->validated();

        $usuario->update($data);

        return new UsuarioResource($usuario);
    }

    /**
     * @OA\Delete(
     *   path="/api/usuarios/{id}",
     *   summary="Eliminar usuario",
     *   tags={"Usuarios"},
     *   @OA\Parameter(
     *     name="id", in="path", required=true, @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=204, description="Eliminado"),
     *   @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return response()->noContent();
    }
}
