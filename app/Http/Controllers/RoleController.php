<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        return view('Dashboard.roles',compact('roles'));
    }

    public function store(Request $request) {
        $rules = [
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255'
        ];

        $validatedData = $request->validate($rules);
        $role = new Role();
        $role->name = $validatedData['name'];
        $role->description = $validatedData['description'] ?? '';
        $role->save();

        if($role){
            return response()->json([
                'message' => 'Role is created successfully',
                'success' => true,
                'role' => $role
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to create role',
                'success' => false,
            ]);
        }

    }

    public function assignRoleForm(){
        $roles = Role::all();
        $users = User::all();
        return view('Dashboard.assign_role',compact('roles','users'));
    }

    public function assignRole(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::find($request->user_id);
        $role = Role::find($request->role_id);

        $user->roles()->attach($role->id);

        return response()->json([
            'success' => true,
            'message' => 'Role assigned successfully!',
        ]);
    }

}
