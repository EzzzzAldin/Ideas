<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function register()
    {
        return view("auth.register");
    }

    public function store()
    {
        // Validate Form Data
        $validated = request()->validate([
            "name" => "required|min:3|max:40",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed|min:8",
        ]);

        // Create User
        $user = User::create(
            [
                "name" => $validated["name"],
                "email" => $validated["email"],
                "password" => Hash::make($validated["password"]),
            ]
        );

        // Send Email Welcome
        // Mail::to($user->email)
        //     ->send(new WelcomeEmail($user));

        // Redirect
        return redirect()->route("dashboard")->with("success", "Account Created Successfully");
    }

    public function login()
    {
        return view("auth.login");
    }

    public function authenticate()
    {
        // Validate Form Data
        $validated = request()->validate([
            "email" => "required|email",
            "password" => "required|min:8",
        ]);

        if (auth()->attempt($validated)) {
            // Clean Session If Email & password correct
            request()->session()->regenerate();

            return redirect()->route("dashboard")->with("success", "Logged in Successfully");
        } else {
            return redirect()->route("login")->withErrors([
                "email" => "No matching user found with the provided email and password",
            ]);
        }
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route("dashboard")->with("success", "Logged out Successfully");
    }
}
