<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'unique_id' => 'ADM' . time(),
            'name' => 'Super Admin',
            'email' => 'admin@shyeyes.com',
            'password' => Hash::make('admin123'),
            'phone' => '9876543210',
            'is_active' => true,
        ]);
    }
}
