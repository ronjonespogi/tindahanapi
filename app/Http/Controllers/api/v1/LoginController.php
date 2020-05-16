<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //user can login using email or username
    public function login(Request $request)
    {
        $email = $request->email;
        $username = $request->username;
        $password = $request->password;

        if($email)
        {
            $cred = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string'
            ]);
            if(!Auth::attempt($cred))
            {
                return response(['status' => 201, 'message' => 'Invalid Username or Password!']);
            }
            //get token
            $token = Auth::user()->createToken('authToken')->accessToken;
            return response(['status' => 200, 'user' =>Auth::user(), 'token' => $token  , 'message' => 'Login Successful!']);
        }
        else if($username)
        {
            $cred = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string'
            ]);
            if(!Auth::attempt($cred))
            {
                return response(['status' => 201, 'message' => 'Invalid Username or Password!']);
            }
            //get token
            $token = Auth::user()->createToken('authToken')->accessToken;
            return response(['status' => 200, 'user' =>Auth::user(), 'token' => $token  , 'message' => 'Login Successful!']);
        }
        else
        {
            return response(['status' => 500 , 'message' => 'Cannot Login!']);
        }




    }
}
