<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function registerView()
    {
        if (Auth::check()) {
            return redirect("/");
        }

        return view("users.register");
    }

    public function loginView()
    {
        if (Auth::check()) {
            return redirect("/");
        }

        return view("users.login");
    }

    public function registerUser(Request $request)
    {
        $formFileds = $request->validate([
            "name" => ["required", "min:15"],
            "email" => ["required", "email", Rule::unique("users", "email")],
            "password" => ["required", "confirmed", Password::min(8)->letters()->numbers()->mixedCase()->symbols()],
        ]);

        // hashing password
        $formFileds["password"] = bcrypt($formFileds["password"]);

        // registers user
        $user = User::create($formFileds);

        // currently authenticated user
        Auth::login($user);

        return redirect("/")->with("message", ' $formFileds["name"] registered and logged in successfully');
    }


    public function loginUser(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect("/")->with("message", "Logged In Successfully");
        }

        return back()->withErrors(["email" => "Invalid credentials"])->onlyInput("email");
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/user/login")->with("message", "You have been logged Out");
    }
}
