<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Регистрация пользователся
    public function register(RegisterRequest $request)
    {
        // Извлекаем role_id для роли "Пользователь"
        $role_id = Role::where('code', 'user')->first()->id;
        // Извлекаем валидированные данные
        $validated = $request->validated();
        // Создаем новго пользователя
        $user = User::create(array_merge($validated,['role_id' => $role_id]));
        // Создание токена для пользователя
        $user->createToken('remember_token')->plainTextToken;
        // Возвращаем ответ от токена
        return response()->json([
            'user' => new UserResource($user),
            'token' => $token
        ])->setStatusCode(201);
    }

    // Авторизация
    public function login(Request $request) {
        if (!Auth::attempt($request->only('login', 'password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return Auth::
    }

    // Выход
    public function logout() {
}
