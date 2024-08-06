<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function adminPage()
    {
        $activeUsers = User::where('is_active','1')->get();
        $activeUsersCount = $activeUsers->count();
        return view('dashboard.index',compact('activeUsersCount'));
    }

    public function usersList()
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    public function activeUsers(){
        $activeUsers = User::where('is_active','1')->get();
        $activeUsersCount = $activeUsers->count();
        return response()->json([
            'success' => true,
            'activeUsersCount' => $activeUsersCount
        ]);
    }


}
