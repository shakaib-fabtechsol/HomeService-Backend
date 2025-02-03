<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function Register(Request $request){

     $data=$request->all();

     $user=User::create($data);

     return response()->json([
        'message' => 'User successfully registered!',
        'user' => $user,
    ], 201);
    }

    public function Userlogin(Request $request)
    {

       
        $data=$request->validate([

            'email'=>['required','email','exists:users'],
            'password'=>['required','min:6'],

        ]);

        $user=User::where('email',$data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
          
           
            return response()->json([

                'message'=>'Bad Creds'
            ]);

        }
        $token=$user->createToken('auth_token')->plainTextToken;

        return [

            'user'=>$user,
            'token' => $token
        ];

    }
}
