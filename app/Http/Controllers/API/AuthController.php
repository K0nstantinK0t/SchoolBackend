<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Controls authentication
 * Class AuthController
 * @package App\Http\Controllers\API
 */
class AuthController extends Controller
{
    /**
     * Register user
     * @param $request Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'unique:users'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        //  password hashing
        $input['password'] = bcrypt($input['password']);
        $input['role'] = 'user';
        // create a new user
        $user = User::create($input);
        // create token
        $token = $user->createToken($user->email)->plainTextToken;

        return response()->json(['token' => $token, 'role' => $user->role], 200);
    }

    /**
     * Generate response with token instance
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function token(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        // get user
        $user = User::where('email', $request->email)->first();

        // check data correct
        if (!$user || !Hash::check($request->password, $user->password))
            return response()->json(['errors' => 'The provided credentials are incorrect.'], 401);

        // return generated token
        return response()->json([
            'token' => $user->createToken($user->email)->plainTextToken, 'role'
            => $user->role], 200);
    }

    /**
     * Delete all tokens attached to user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logOut(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'tokens deleted successful'], 200);
    }

    /**
     * Check existing of token
     * @return \Illuminate\Http\JsonResponse
     */
    public function isValidToken()
    {
        // request coming here if it has  passed the sanctum middleware protection. So token is existing.
        // if you know other way how realize it, please report me
        return response()->json(['message' => 'so token exists', 'result' => true], 200);
    }
}
