<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function register()
    {
        return view('register');
    }
    
    public function registerPost(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->password);
        
        $user->save();
        
        return back()->with('success', 'Register successfully');
    }

    public function login()
    {
        return view('login');
    }

    public function loginPost(Request $request)
    {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                 $user = Auth::user();  
                $token = $user->createToken('MyApp')->accessToken;
                return redirect('/dashboard')->with('success', 'Login Success', 'access_token', $token);
            }
            return back()->with('error', 'Error Email or Password');
    }

    public function logout()
    {
        Auth::logout();
 
        return redirect()->route('login');
    }
}
