<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Auth\LoginController;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Переопределение метода login
    public function login(Request $request)
    {
        // Валидация входящих данных
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Попытка аутентификации
        if (Auth::attempt($credentials)) {
            // Аутентификация успешна
            $user = Auth::user();

            // Генерация токена
            $token = $user->createToken('authToken')->plainTextToken;

            // Возвращаем JSON-ответ с токеном, типом токена и временем действия
            return response()->json([
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => 86400,
                ],
            ], 200);
        }

        // Если аутентификация не удалась
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    // Метод для выхода из системы (logout)
    public function logout(Request $request)
    {
        // Убедитесь, что пользователь аутентифицирован
        if ($user = $request->user()) {
            // Удаление текущего токена (если существует)
            if ($token = $user->currentAccessToken()) {
                $token->delete();
            }
            
            Auth::logout();

            return response()->json(['message' => 'Successfully logged out']);
        }

        return response()->json(['message' => 'No authenticated user'], 401);
    }
}
