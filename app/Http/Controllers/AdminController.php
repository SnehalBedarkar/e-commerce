<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function adminPage()
    {
        $activeUsers = User::where('status','1')->get();
        $activeUsersCount = $activeUsers->count();
        $totalRevenue = DB::table('orders')->sum('total');

        return view('dashboard.index',compact('activeUsersCount','totalRevenue'));
    }

    public function usersList()
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    public function activeUsers() {
        // Fetch all active users
        $activeUsers = User::where('status', 'active')->get();

        // Get the count of active users
        $activeUsersCount = $activeUsers->count();

        // Return the count in JSON format
        return response()->json([
            'success' => true,
            'activeUsersCount' => $activeUsersCount
        ]);
    }


    public function settings(){
        return view('Dashboard.settings');
    }

}
