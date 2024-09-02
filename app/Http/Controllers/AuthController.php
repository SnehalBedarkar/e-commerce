<?php

namespace App\Http\Controllers;

use App\Mail\UserRegistered;
use App\Mail\OtPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\CartItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;



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
            'role_id' => 'nullable|exists:roles,id', // role_id is now optional
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
            // Create the user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'phone_number' => $data['phone_number'],
            ]);

            // Attach the role to the user if role_id is present
            if (isset($data['role_id'])) {
                $user->roles()->attach($data['role_id']);
            }

            // Send a registration email
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
        $data = $request->only('login_email', 'login_password', 'remember_me');

        $rules = [
            'login_email' => 'required|exists:users,email',
            'login_password' => 'required|min:8',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'errors' => $validator->errors()->all()
            ]);
        }

        // Extract the credentials
        $credentials = [
            'email' => $data['login_email'],
            'password' => $data['login_password']
        ];

        $remember = $data['remember_me'] ?? false;

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Store session cart items in the database
            $cart = session()->get('cart', []);
            foreach ($cart as $item) {
                // Insert or update cart item in the database
                CartItem::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'product_id' => $item['product_id']
                    ],
                    [
                        'quantity' => $item['quantity']
                    ]
                );
            }

            // Optionally clear the session cart
            session()->forget('cart');

            // Fetch user's role
            $role = $user->roles()->first()->name ?? 'user'; // Adjust if your role relation differs

            // Determine the redirect URL based on role
            switch ($role) {
                case 'Product Manager':
                    $redirectUrl = '/products/index';
                    break; // Added break to avoid falling through to next case
                case 'Super Admin':
                    $redirectUrl = '/adminPage';
                    break; // Added break to avoid falling through to next case
                default:
                    $redirectUrl = '/'; // Default redirect for roles not explicitly handled
            }

            return response()->json([
                'success' => true,
                'redirect_url' => $redirectUrl,
                'remember_token' => $user->remember_token
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password.'
        ]);
    }


    public function logout(Request $request)
    {
        // Log out the user
        Auth::logout();
        // Redirect to the home page or login page
        return redirect()->route('home');
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
                'errors' => $validator->errors()->all()
            ]);
        }

        $email = $data['email'];

        $otp = mt_rand(100000, 999999);

        $user = User::where('email',$email)->first();

        $user->otp = $otp;

        $user->otp_expires_at = now()->addMinutes(10);
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


    public function loginPage(){
        return view('Dashboard.login_page');
    }


}
