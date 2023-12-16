<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistroRequest;

class AuthController extends Controller
{
    //definimos las reglas de validacion en el archivo registroRequest
    public function register(RegistroRequest $request)
    {
        $data = $request->validated();e:

        //Crear el usuario
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        //retornar una respuesta
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        //Revisar password
        if(!Auth::attempt($data)){
            return response([
                'errors' => ['El email o password son incorrectos']
            ],422);
        }

        //autenticar usuario
        $user = Auth::user();
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];

    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return [
            'user' => null
        ];
    }
}
