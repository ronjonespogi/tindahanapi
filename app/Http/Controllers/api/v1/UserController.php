<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function register()
    {
        $email = request()->email;
        $username = request()->username;
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'username' => 'required'
        ]);

        //check if email is taken
        $emailTaken = User::where('email', $email)->get();
        //check if username is taken
        $usernameTaken = User::where('username', $username)->get();

        if(sizeOf($emailTaken) > 0)
        {
            return response(['status' => 500, 'message' => 'Email is already taken. Please input a different email.']);
        }
        if(sizeOf($usernameTaken) > 0)
        {
            return response(['status' => 500, 'message' => 'Username is already taken. Please input a different username.']);
        }


        if($user = User::create(request(['name', 'email', 'password', 'username'])))
        {
            return response(['status' => 200, 'message' => 'User Created!', 'user' => $user]);
        }
        else
        {
            return response(['status' => 500, 'message' => 'Error registering user']);
        }
    }

    public function userInfo()
    {
        return Auth::user();
    }

    public function test()
    {
        return ('yow what the fuck?');
    }
}
