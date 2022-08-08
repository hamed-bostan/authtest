<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validate=Validator::make($request->all(),[
            'first_name'=>['required','string'],
            'last_name'=>['required','string'],
            'email'=>['required','email','unique:users'],
            'password'=>['required','confirmed','min:3'],
        ]);

        if ($validate->fails())
        {
            return response()->json([
               'message'=>'your input were invalid'
            ],400);
        }

        else
        {
             $user= new User([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'activation_token'=>Str::random(60),
            'register_ip'=>$request->ip()
             ]);

             $user->save();

             return response()->json([
                'message'=>'registering wsa successful'
             ],201);

        }
    }
}

