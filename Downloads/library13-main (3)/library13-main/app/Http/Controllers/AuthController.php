<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|max:175|unique:users',
            'password' => 'required|min:6',
            'gender' => 'required|in:M,F',
            'phone' => 'required|digits:10',
           'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048' 
        ]);
   $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'type' => 'customer' 
        ]);
         $avatarPath = null;
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $avatar = $request->file('avatar');
            
            
            $avatarName = 'avatar_' . time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            
        
            $avatarPath = $avatar->storeAs('avatars', $avatarName, 'public');
        }

        /* create customer without avatar 😢 */
        $user->customer()->create([
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
             'avatar' => $avatarPath,
        ]);

        return ResponseHelper::success(
            "user created successfully",
            [
                'user' => $user,
                'token' => $user->createToken("Api Token")->plainTextToken
            ]
        );
    }
    function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password,  $user->password)) {
            return ResponseHelper::success("user logged successfully", [
                'user' => $user,
                'token' => $user->createToken("Api Token")->plainTextToken,
            ]);
        } else
            return ResponseHelper::error("invalid credential");
    }

    function logout()
    {
        $token = Auth::user()->currentAccessToken()->delete();
        return ResponseHelper::success("user logout successfully");
    }
}
