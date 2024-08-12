<?php

namespace App\Http\Controllers;

use App\Mail\UserRegistered;
use App\Mail\OtPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $data = $request->only('login_email', 'login_password' , 'remember_me');
        

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

        $remember = $data['remember_me'] ?? false;
        


        if (Auth::attempt($credentials ,$remember)) {
            $user = Auth::user();
            $remember_token = $user->remember_token;
            $redirectUrl = $user->role === 'admin' ? '/adminPage' : '/';
            return response()->json([
                'success' => true,
                'redirect_url' => $redirectUrl,
                'remember_token' => $remember_token
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
        // $cookie = Cookie::forget('remember_web_' . config('app.key'));
        return response()->json([
            'success' => true,
            'message' => 'You are logged out successfully',
            'redirect_url' => '/',
        ]);
    }

    public function showForgotPassword()
    {
        return view('home.forgot_password');
    }

    public function forgotPassword(Request $request)
    {

        $data = $request->all();

        $rules = [
           'email' => 'required|email|exists:users,email',
        ];

        $validator = Validator::make($data,$rules);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'email is not valid',
            ]);
        }

        $email = $data['email'];

        $otp = mt_rand(100000, 999999);

        $user = User::where('email',$email)->first();

        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(1);
        $user->save();

        $otp = $user->otp;

        Mail::to($email)->send(new OtPMail($otp));

        return response()->json([
            'success' => true,
            'message' => 'OTP send to your email'
        ]);

    }

    public function verifyOtp(Request $request)
    {
        $data = $request->all();
    
        $rules = [
            'otp' => 'required|digits:6',
        ];
    
        $validator = Validator::make($data, $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'OTP is not valid',
                'errors' => $validator->errors(),
            ], 422);  // 
        }
    
        $otp = $data['otp'];
    
        $user = User::where('otp', $otp)->first();
    
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP',
            ], 404);  
        }
    
        if ($user->otp_expires_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired',
            ], 403);  
    
        }

        $user->otp = null;  // Optionally clear the OTP
        $user->save();

        $redirectUrl = url('/auth/register-new-password-form');

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully',
            'user' => $user,
            'redirectUrl' => $redirectUrl
        ], 200);  // Return success response with user data  
    }

    public function passwordResetForm(){
        return view('home.password_reset');
    }

    public function resetPassword(Request $request){
        $data = $request->all();

        $rules = [
            'password' => 'required|string|min:8|confirmed',
            'email' => 'required|email|exists:users,email',
        ];

        $validator = Validator::make($data,$rules);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(), 
            ]);
        }

        $password = $data['password'];
        $email = $data['email'];

        $user = User::where('email',$email)->first();

        if($user){
            $user->password = bcrypt($password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password Reset Successfully',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'user not found'
            ]);
        }
    }

    

}