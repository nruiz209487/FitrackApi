<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;
use App\Http\Requests\InsertUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserEntityController
{

    /**
     * 
     * @OA\Get(
     *     path="/api/user/{email}",
     *     summary="Obtener token de acceso por ID de usuario",
     *     tags={"User"},
     *  
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token generado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJK...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     )
     * )
     */
    public function getByEmail($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
            'user' => [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'streak_days' => $user->streak_days,
                'profile_image' => $user->profile_image,
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/user/register",
     *     summary="Registrar nuevo usuario",
     *     tags={"User"},
     *    
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
    *             required={"email", "password", "password_confirmation"},
    *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
    *             @OA\Property(property="password", type="string", format="password", example="secret123"),
    *             @OA\Property(property="password_confirmation", type="string", format="password", example="secret123"),
    *             @OA\Property(property="name", type="string", example="Juan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario registrado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Usuario registrado exitosamente"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="email", type="string", example="user@example.com"),
     *                 @OA\Property(property="name", type="string", example="Juan"),
     *                 @OA\Property(property="token", type="string", example="eyJhbGciOi...")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al registrar usuario"
     *     )
     * )
     */
public function register(InsertUserRequest $request)
{
    try {
        $user = User::create([
            'name' => $request->name ?? 'Usuario',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'streak_days' => 1,
            'profile_image' => null,
            'email_verified_at' => null,
            'gender' => $request->gender,
            'height' => $request->height,
            'weight' => $request->weight
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado exitosamente',
            'data' => [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'gender' => $user->gender,
                'height' => $user->height,
                'weight' => $user->weight,
                'token' => $user->createToken('api-token')->plainTextToken,
            ]
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al registrar usuario',
            'error' => $e->getMessage()
        ], 500);
    }
}
    /**
     * @OA\Put(
     *     path="/api/user/update",
     *     summary="Actualizar información del usuario",
     *     tags={"User"},
     *   security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="newpass456"),
     *             @OA\Property(property="name", type="string", example="Juan Actualizado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario registrado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al registrar usuario"
     *     )
     * )
     */
    public function updateRequest(UpdateUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name ?? 'Usuario',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'streak_days' => 0,
                'profile_image' => null,
                'email_verified_at' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado exitosamente',
                'data' => [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'token' => $user->createToken('api-token')->plainTextToken,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/users/delete/{user_id}",
     *     summary="Eliminar usuario por ID",
     *     tags={"User"},
     *   security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario eliminado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Usuario eliminado exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     )
     * )
     */
    public function delete($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado exitosamente'
        ]);
    }
}
