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
        return response()->json([
            'status' => true,
        ]);
    }

    public function login(Request $request)
    {
        // Validate the form data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return response()->json(['success' => true, 'redirect_url' => '/']);
        }

        // Authentication failed...
        return response()->json(['success' => false, 'message' => 'Invalid credentials.']);
    }



    public function showRegistraitionForm()
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
            'phone_number' => 'required|numeric',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Errors',
                'errors' => $validator->errors()->all(),
            ], 401);
        }

        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']), // Hash the password for security
                'phone_number' => $data['phone_number'],
            ]);


            if ($user) {
                Mail::to($user->email)->send(new UserRegistered($user));
                return response()->json([
                    'success' => true,
                    'redirect_url' => '/auth/login',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create user.',
                ]);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            Log::error('User registration failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create user.',
            ]);
        }
    }



    public function logout()
    {
        Auth::logout(); // Logs the user out
        return response()->json([
            'success' => true,
            'redirect_url' => '/',
        ]);
    }
}
