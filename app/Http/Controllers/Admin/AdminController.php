<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function adminPage()
    {
        return view('Dashboard.dashboard');
    }

    public function usersList(){
        $users = User::all();
        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }


}
