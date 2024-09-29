<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request) {
        $request->validated();
        
        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];
        $user = User::create($userData);
        $token = $user->createToken('apiTest')->plainTextToken;

        return response([
            'token' => $token, 
            'user' => $user,
        ], 201);
    }

    public function login(LoginRequest $request){
        $request->validated();
        
        $user = User::whereUsername($request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Invalid credentials',
            ],422);
        }
        
        $token = $user->createToken('apiTest')->plainTextToken;

        return response([
            // 'code' => 200,
            // 'msg' => 'User created Successfully',
            // 'data' => $userInfo
            'token' => $token, 
            'user' => $user,
        ], 200);
    }
}
