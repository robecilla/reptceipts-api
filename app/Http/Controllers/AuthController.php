<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
		try {
			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => bcrypt($request->password),
			]);
		} catch(\Exception $e) {
			// User already exists
            return response()->json('User is already registered', 409);
		}

		$token = JWTAuth::fromUser($user);

        return response()->json('Registered successfully', 200);
	}

	public function login(Request $request)
	{
		$login = $request->only('email', 'password');

		try {
			if (! $token = JWTAuth::attempt($login)) {
			   return response()->json('Invalid credentials', 401);
			}
		} catch (JWTException $e) {
            return response()->json('Could not create jwt', 500);
		}

		return response()->json(compact('token'));
	}
}
