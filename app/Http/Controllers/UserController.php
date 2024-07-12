<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index-user', compact('users'));
    }

    public function showRegistraitionForm()
    {
        return view('users.register-user');
    }

    public function processRegistraition(Request $request)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|numeric',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create($data);

        if ($user) {
            return redirect()->route('user.create.login')->with('status', 'user registered successfully');
        }
    }

    public function showLoginForm()
    {
        return view('users.login-form');
    }

    public function processLogin(Request $request)
    {
        $crenditials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt($crenditials)) {
            return redirect()->route('products.index');
        } else {
            return back()->withErrors(['email' => 'invalid credentials'])->withInput();
        }
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.show-user', compact('user'));
    }

    public function edit()
    {
        return view('users.edit-user');
    }

    public function destroy()
    {
        //
    }
}
