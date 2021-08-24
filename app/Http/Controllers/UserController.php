<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $user = User::query()->where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['email' => 'The provided credentials are incorrect']);
        }

        return response(['token' => $user->createToken("access_token_$user->id")->plainTextToken], 200);
    }

    public function logout(Request $request): Response
    {
        $request->user()->tokens()->delete();

        return response([], 200);
    }
}
