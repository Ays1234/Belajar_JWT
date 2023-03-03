<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register()
    {
        $validator = Validator::make(request()->all(),
        ['name' => 'required',
        'email' => 'required|email|unique:users',
         'password' => 'required']);
    if($validator->fails()){
        return response()->json($validator->messages());
    }

    $user =User::create([
        'name' => request('name'),
        'username' => request('username'),
    'email' => request('email'),
    'phone'=> request('phone'),
    'dial_code'=> request('dial_code'),
    'country_code'=> request('country_code'),
    'password' => Hash::make(request('password')),
    'gender'=>request('gender'),
    'dob'=>request('dob'),
    'avatar'=>request('avatar')
]);

    if ($user){
        // return response()->json(['message' => 'Pendaftaran']);

        return response()->json([
            'message' => 'success',
            'user' => $user,
        ], 200);
    }else{
        return  response()->json(['message'=>'Pendaftaraan gagal']);
    }

    }


    public function login(){
        $credentials = request(['email', 'password']);
        if(! $token = auth()->attempt($credentials)){
            return response()->json(['error' => 'Unauthorized', 401]);
        }
        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

}
