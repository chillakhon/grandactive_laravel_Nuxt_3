<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:30', 'unique:' . User::class],
            'password' => ['required', 'min:8'] //'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'user' => $user,
        ]);
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('API_TOKEN');
        } else {
            return response()->json([
                'message' => 'net user'
            ], 401);
        }
        return response()->json(
            [
                'user' => Auth::user(),
                'token' => $token->plainTextToken
            ]
        );
    }
    public function logout(){
        Auth::user()->tokens()->delete();
        return response()->json([
          'message' => 'logout'
        ]);
    }
}
