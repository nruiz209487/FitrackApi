<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;
use App\Http\Requests\InsertUserRequest;
use App\Http\Requests\UpdateUserRequest;


class UserEntityController
{
    public function getByUserId($user_id)
    {
        $user = User::where('id', $user_id)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
        ]);
    }

    public function register(InsertUserRequest $request)
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
