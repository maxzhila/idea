<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(){
        return view('auth.register');
    }
    public function store(){
        $validated = request()->validate(
            [
                'name'=>'required|min:3|max:40',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|confirmed',
                
            ]
        );

            $user = User::create([
                'name'=>$validated['name'],
                'email'=>$validated['email'],
                'password'=>Hash::make($validated['password'])
            ]);
            

            // Auth::login($user);

            // return redirect(route('dashboard'));
            auth()->attempt($validated);
            request()->session()->regenerate();
            return redirect()->route('dashboard')->with('success','Account created successfuly');
    }
    public function login(){
        return view('auth.login');
    }

    public function authenticate(){
        $validated = request()->validate([
                'email'=>'required|email',
                'password'=>'required|'
            ]);
            if (auth()->attempt($validated)) {
                request()->session()->regenerate();
                return redirect()->route('dashboard')->with('success','Logged in successfully!');

            }
            else{
            return redirect()->route('login')->withErrors([
                'email'=> 'No matching user found with the provided email and password'
                ]);
            }
    }

    public function logout(){
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('dashboard')->with('success','logged out successfully!');
    }
}
