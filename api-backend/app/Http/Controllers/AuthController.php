<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Exceptions\Renderer\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function register(Request $request){

        try {

            $data = $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,eamil",
            "paassword" => "required",
        ]);

        User::create($data);

        return response()->json([
            "status" => true,
            "message" => "User registered successfully."
        ], 201);

        } catch (Exception $e) {
            //  Log::error("error" . $e);
                return response()->json([
                "status" => false,
                "message" => "Something went while user is registered."
            ]);
        }
    }

    public function login(Request $request){

        $request->validate([
            "email" => "required|email",
            "paassword" => "required",
        ]);

        if(Auth::attempt($request->only("email", "password"))){
            return response()->json([
                "status" => false,
                "message" => "Invalid credintials."
            ]);
        }

        $user = Auth::user();

        $token = $user->createToken("myToken")->plainTextToken;

        return response()->json([
            "status" => true,
            "message" => "User logged in.",
            "token" => $token
        ]);
    }

    public function profile(){

        $user = Auth::user();

        return response()->json([
            "status" => true,
            "message" => "User profile data.",
            "user" => $user
        ]);
    }

    public function logout(){

        Auth::logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully."
        ]);
    }
}
