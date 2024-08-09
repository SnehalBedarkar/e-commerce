<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistered;

class AuthController extends Controller
{
    public function register(Request $request)
    { 
        $data = $request->all();

        $rules = [
            'name' => 'required|string|max:25',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'phone_number' => 'required|numeric',
        ];

        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Errors',
                'errors' => $validator->errors()->all(),
            ], 200);
        }
        
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'phone_number' => $data['phone_number'],
                'role' => 1
            ]);

            if ($user) {
                Mail::to($user->email)->send(new UserRegistered($user));
                return response()->json([
                    'success' => true,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create user.',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('User registration failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user.',
            ]);
        }
    }

    public function login(Request $request)
    {
        $data = $request->only('login_email', 'login_password');

        $rules = [
            'login_email' => 'required|exists:users,email',
            'login_password' => 'required|min:8'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'errors' => $validator->errors()->all()
            ]);
        }

        // extract the credential 

        $credentials = [
            'email' => $data['login_email'],
            'password' => $data['login_password']
        ];


        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $redirectUrl = $user->role === 'admin' ? '/adminPage' : '/';
            return response()->json([
                'success' => true,
                'token' => $user->createToken('API Token')->plainTextToken,
                'token_type' => 'bearer',
                'redirect_url' => $redirectUrl,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password.'
        ]);
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'User logged Out Successfully',
            'user' => $user,
        ]);
    }
}
