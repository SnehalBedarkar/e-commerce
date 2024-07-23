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
        return view('Dashboard.users',compact('users'));
    }


    public function activeUsers()
    {
        $users = Auth::user();
        return response()->json([
            'success' => true,
            'users' => $users
        ]);
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
