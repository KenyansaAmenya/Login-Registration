<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthManager extends Controller
{
    //Login function
    function login()
    {
        if (Auth::check()){
            return redirect(route('home'));
        }
        return view('login');
           
    }
    //Registration function
    function registration()
    {
        return view('registration');
    }
    //This function will be receiving a request which contains all the data that is passed from the login form
    function loginPost(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)) {
            return redirect()->intended(route('home'));
        }

        //if the above is false it returns an error message which redirects the user to the login page
        return redirect(route('login'))->with("error", "Login details are not valid");
    }

    //This function will be receiving a request which contains all the data that is passed from the registration form
    function registrationPost(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        if(!$user) {
            return redirect(route('registration'))->with("error", "registration failed try again.");
        }

        return redirect(route('login'))->with("success", "registration successful, login to access the app");
    }
    
    //logout function
    function logout() {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}