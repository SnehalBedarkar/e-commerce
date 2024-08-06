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
        return view('dashboard.users',compact('users'));
    }


    public function chartData()
    {
        $users = User::all();


        $labels = $users->groupBy(function($date) {
            return $date->created_at->format('Y-m-d'); // Group by month and year
        })->keys();

        $values = $users->groupBy(function($date) {
            return $date->created_at->format('Y-m-d');
         })->map->count()->values();
        return response()->json([
            'success'=> true,
            'labels' => $labels,
            'values' => $values
        ]);        
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
        return view('home.profile', compact('user'));
    }

    public function edit()
    {
        return view('users.edit-user');
    }

    public function destroy(Request $request)
    {   
        $data = $request->all();
        $userId = $data['user_id'];
        $user = User::where('id',$userId);
        $user->delete();
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function multipleDelete(Request $request)
    {
        $data = $request->all();
        $userIds = $data['user_ids'];

        if (is_array($userIds) && !empty($userIds)) {
            $users = User::destroy($userIds); // Destroy method takes an array of IDs directly

            if ($users > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Users deleted successfully.',
                    'users' => $users,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete users.',
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid user IDs.',
        ]);
    }

}
