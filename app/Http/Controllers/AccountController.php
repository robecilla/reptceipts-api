<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AccountController extends Controller
{
	// Sign up
    public function index(Request $request)
	{

		try {
			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => bcrypt($request->password),
			]);
		} catch(\Exception $e) {
			// User already exists
			return response()->json($e->errorInfo, 409);
		}


		$token = JWTAuth::fromUser($user);

		return response()->json(compact('token'));
		//return response()->json($user, 201);
	}
}
