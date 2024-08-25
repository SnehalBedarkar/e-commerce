<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\File;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get('database/json/users.json');
        $users = collect(json_decode($json));

        $users->each(function($userData) {
            $user = new User();
            $user->id = $userData->id;
            $user->name = $userData->name;
            $user->is_active = $userData->status;
            $user->email = $userData->email;
            $user->role = $userData->role;
            $user->phone_number = $userData->phone_number;
            $user->password = bcrypt('password'); // Set a default password
            $user->save();
        });
    }
}
