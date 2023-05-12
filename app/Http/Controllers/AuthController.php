<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getUsers()
    {
        return User::where('status', 0)->orderBy('created_at', 'ASC')->get();
    }

    public function verify($id)
    {
        return User::find($id)->update(['status' => 1]);
    }

    public function register(Request $request)
    {
        $taken = User::where('email', $request['email'])->first();
        if ($taken) {
            return response(['message' => "Email is already taken!"], 201);
        } else {
            $fields = $request->validate([
                'name' => 'required|string',
                'role' => 'required|string',
                'email' => 'required|string',
                'phone' => 'required|string',
                'password' => 'required|string',
                'address' => 'required|string',
            ]);
        }

        $user = User::create([
            'name' => $fields['name'],
            'role' => $fields['role'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'address' => $fields['address'],
            'password' => bcrypt($fields['password']),
            'status' => 0
        ]);

        // $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'message' => 'success',
            'user' => $user,
            // 'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Bad creds'], 201);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'message' => 'success',
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $user = User::find($request['user']);
        $user->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
