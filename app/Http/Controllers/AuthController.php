<?php

namespace App\Http\Controllers;

use App\Mail\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('partials.home.login_modal');
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
                'redirect_url' => $redirectUrl,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password.'
        ]);
    }

    public function showRegistrationForm()
    {
        return view('Auth.register_form');
    }

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

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'success' => true,
            'message' => 'You are logged out successfully',
            'redirect_url' => '/',
        ]);
    }
}
