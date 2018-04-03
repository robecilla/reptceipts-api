<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
		return response()->json([
            'code' => 200,
            'response' => $user->all()
        ], 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function JWTuser()
    {
		try {
			if (! $user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json(['token_expired'], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response()->json(['token_invalid'], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
			return response()->json(['token_absent'], $e->getStatusCode());
		}

		// the token is valid and we have found the user via the sub claim
		return response()->json([
            'code' => 200,
            'response' => compact('user')
        ], 200);
    }

    /**
     * Creates a new user record.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
			$user = User::create([
				'email' => $request->email,
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
        
        return response()->json([
			'code' => 200,
			'response' => compact('user')
		], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json([
            'code' => 200,
            'response' => compact('user')
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = User::find($user->id);

        foreach ($request->all() as $key => $var) {
           if(!empty($var) && $key !== '_method') {
                if($key === 'password') {
                    $user->$key = bcrypt($var);
                } else {
                    $user->$key = $var;
                }
            }
        }

        $user->save();

        return response()->json([
            'code' => 200,
            'response' => 'Updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'code' => 200,
            'response' => 'Deleted successfully'
        ], 200);
    }
}
