<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;
use App\Http\Requests\InsertUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Log;

/**
 * Class UserEntityController
 * @package App\Http\Controllers
 *
 * Controlador para la entidad User
 */
class UserEntityController
{
    /**
     * @OA\Post(
     *     path="/api/user/{email}",
     *     summary="Obtener token de acceso por email de usuario",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"password"},
     *             @OA\Property(property="password", type="string", format="password", example="pass123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token generado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJK..."),
     *             @OA\Property(property="user", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales inválidas"
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
        if (!$user || !request()->has('password') || !Hash::check(request()->input('password'), $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 401);
        }
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }


        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
            'user' => [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'streakDays' => $user->streakDays,
            'profileImage' => $user->profileImage,
            'lastStreakDay' => $user->lastStreakDay,
            'gender' => $user->gender,
            'height' => $user->height,
            'weight' => $user->weight
        ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/user/register",
     *     summary="Registrar un nuevo usuario",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="pass123"),
     *             @OA\Property(property="name", type="string", example="Juan"),
     *             @OA\Property(property="gender", type="string", example="male"),
     *             @OA\Property(property="height", type="number", format="float", example=1.75),
     *             @OA\Property(property="weight", type="number", format="float", example=70.5)
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
    public function register(InsertUserRequest $request)
    {    
        $validAppKey = "+dfx8gyAR##d3'f9G8Gfj@fj3f57as63s/1?" === $request->calveApp;
        
        if ($validAppKey){
        try {
            $user = User::create([
                'name' => $request->name ?? 'Usuario',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'streakDays' => 1,
                'lastStreakDay' => $request->lastStreakDay ?? now(),
                'profileImage' => null,
                'gender' => $request->gender,
                'height' => $request->height,
                'weight' => $request->weight
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado exitosamente',
                'data' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'gender' => $user->gender,
                'height' => $user->height,
                'weight' => $user->weight,
                'streakDays' => $user->streakDays,
                'lastStreakDay' => $user->lastStreakDay, 
                'profileImage' => $user->profileImage,
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
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Clave de la aplicación no válida'
            ], 401);
        }
    }


    /**
     * @OA\Put(
     *     path="/api/user/update/{id}",
     *     summary="Actualizar información del usuario",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="newpass456"),
     *             @OA\Property(property="name", type="string", example="Juan Actualizado"),
     *             @OA\Property(property="gender", type="string", example="male"),
     *             @OA\Property(property="height", type="number", format="float", example=1.75),
     *             @OA\Property(property="weight", type="number", format="float", example=70.5),
     *             @OA\Property(property="streakDays", type="integer", example=15),
     *             @OA\Property(property="profileImage", type="string", example="https://example.com/images/profile-juan.jpg"),
     *             @OA\Property(property="lastStreakDay", type="string", format="date-time", example="2024-06-01T00:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al actualizar usuario"
     *     )
     * )
     */
    public function updateRequest(UpdateUserRequest $request, $id)
    {
        try {
            
            $user = User::find($id);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado',
                    'data' => null
                ], 404);
            }


            $user->update([
                'name' => $request->name ?? $user->name,
                'email' => $request->email ?? $user->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'streakDays' => $request->streakDays ?? $user->streakDays, 
                'profileImage' => $request->profileImage ?? $user->profileImage,
                'lastStreakDay' => $request->lastStreakDay ?? $user->lastStreakDay,
                'gender' => $request->gender ?? $user->gender,
                'height' => $request->height ?? $user->height,
                'weight' => $request->weight ?? $user->weight,
            ]);

            $user->refresh();


            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado exitosamente',
                'data' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'gender' => $user->gender,
                    'height' => $user->height,
                    'weight' => $user->weight,
                    'streakDays' => $user->streakDays,
                    'lastStreakDay' => $user->lastStreakDay,
                    'profileImage' => $user->profileImage,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at
                ]
            ], 200);
            } catch (\Exception $e) {
                Log::error('Error updating user:', ['error' => $e->getMessage()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar usuario',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
        
        /**
         * @OA\Delete(
         *     path="/api/user/delete/{id}",
         *     summary="Eliminar usuario por ID",
         *     tags={"User"},
         *     security={{"bearerAuth":{}}},
         *     @OA\Parameter(
         *         name="id",
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