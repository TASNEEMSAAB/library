<?php

 namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        
        Customer::create([
            'user_id' => $user->id,
        ]);

        return ResponseHelper::success(
            "Registered successfully",
            [
                'user' => $user,
                'token' => $user->createToken("API Token")->plainTextToken
            ]
        );
    }

    function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return ResponseHelper::success("Login successful", [
                'user' => $user,
                'token' => $user->createToken("API Token")->plainTextToken,
            ]);
        }
        
        return ResponseHelper::error("Invalid credentials");
    }

     
         public function logout(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return ResponseHelper::error('لم يتم تسجيل الدخول', 401);
        }
    
    }
}