<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;
//php artisan l5-swagger:generate

/**
 * @OA\Info(
 *     title="Fitrack",
 *     version="1.0.0",
 *     description="Documentación de la API"
 * )
 * 
 * @OA\Tag(
 *     name="Ejercicios",
 *     description="Operaciones relacionadas con ejercicios"
 * )
 * @OA\Tag(
 *     name="Usuarios",
 *     description="Operaciones relacionadas con usuarios"
 * )
 */
class OpenApiSpec
{
}
