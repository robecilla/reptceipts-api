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
	/**
     * Register
     * Creates a new user in the system and returns an unique JWT
	 * to authorize subsequent calls
     *
     * @param Request $request
     */
    public function register(Request $request) {
		try {
			$user = User::create([
				'email' => strtolower($request->email),
				'password' => bcrypt($request->password),
				'username' => $request->username,
			]);
		} catch(\Exception $e) {
			// User already exists
            return response()->json([
				'code' => 409,
				'response' => 'User is already registered'
			], 409);
		}

		$token = JWTAuth::fromUser($user);

        return response()->json([
			'code' => 200,
			'response' => compact('token')
		], 200);
	}

	/**
     * Log in
     * Logs in an existing user an return an unique JWT
	 * to authorize subsequent calls
     *
     * @param Request $request
     */
	public function login(Request $request)
	{
		try {
			if (!$token = JWTAuth::attempt([
				"email" => strtolower($request->email),
				"password" => $request->password
			])) {
			   return response()->json([
					'code' => 401,
					'response' => 'Invalid credentials, please try again'
				], 401);
			}
		} catch (JWTException $e) {
            return response()->json([
				'code' => 500,
				'response' => 'Could not create JWT'
			], 500);
		}

		return response()->json([
			'code' => 200,
			'response' => compact('token')
		], 200);
	}

	/**
     * Log out
     * Invalidates the token.
     *
     * @param Request $request
     */
    public function logout(Request $request) {
        
        try {
            JWTAuth::invalidate($request->token);
            return response()->json(['code' => 200, 'response'=> "You have successfully logged out."]);
        } catch (JWTException $e) {
            return response()->json(['code' => 500, 'response' => 'Failed to logout, please try again.'], 500);
        }
    }
}
