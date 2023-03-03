<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    'email' => request('email'),
    'password' => Hash::make(request('password')),
]);

    if ($user){
        return response()->json(['message' => 'Pendaftaran']);
    }else{
        return  response()->json(['message'=>'Pendaftaraan gagal']);
    }

    }
}
