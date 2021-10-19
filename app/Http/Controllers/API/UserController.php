<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller
{
    public function register(Request $request){

        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username'=>['required', 'string', 'max:255', 'unique:users'],
                'email'=>['required', 'string','email', 'max:255', 'unique:users'],
                'phone'=>['nullabel', 'string', 'max:255'],
                'password'=>['required', 'string', new Password],
            ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),

            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken();

            return ResponseFormatter::success([
                'acces_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'User Registered');
        } catch (Exception $eror) {
            return ResponseFormatter::error([
                'massage' => 'Something went wrong',
                'error' => $eror,

            ], 'Authentication Failed', 500);
            //throw $th;
        }
    }
}
