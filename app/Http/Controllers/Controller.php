<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="API Biblioteca Digital",
 *   description="Documentación de la API de Biblioteca (Libros, Usuarios, Préstamos)"
 * )
 *
 * @OA\Server(
 *   url=L5_SWAGGER_CONST_HOST,
 *   description="Servidor local"
 * )
 *
 * @OA\Components(
 *   @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 *   )
 * )
 */
abstract class Controller
{
    //
}
