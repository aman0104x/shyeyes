<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 sample users with correct enum values
        $users = [
            [
                'unique_id' => 'USER001',
                'f_name' => 'John',
                'l_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '9876543210',
                'password' => Hash::make('password123'),
                'dob' => '1990-05-15',
                'age' => 34,
                'gender' => 'Male',
                'location' => 'New York, USA',
                'about' => 'Software developer with 5 years of experience',
                'status' => 'block',
                'img' => 'default.jpg'
            ],
            [
                'unique_id' => 'USER002',
                'f_name' => 'Jane',
                'l_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '9876543211',
                'password' => Hash::make('password123'),
                'dob' => '1988-08-22',
                'age' => 36,
                'gender' => 'Female',
                'location' => 'Los Angeles, USA',
                'about' => 'Marketing professional with expertise in digital marketing',
                'status' => 'block',
                'img' => 'default.jpg'
            ],
            [
                'unique_id' => 'USER003',
                'f_name' => 'Michael',
                'l_name' => 'Johnson',
                'email' => 'michael.johnson@example.com',
                'phone' => '9876543212',
                'password' => Hash::make('password123'),
                'dob' => '1992-03-10',
                'age' => 32,
                'gender' => 'Male',
                'location' => 'Chicago, USA',
                'about' => 'Data analyst with strong SQL and Python skills',
                'status' => 'block',
                'img' => 'default.jpg'
            ],
            [
                'unique_id' => 'USER004',
                'f_name' => 'Emily',
                'l_name' => 'Williams',
                'email' => 'emily.williams@example.com',
                'phone' => '9876543213',
                'password' => Hash::make('password123'),
                'dob' => '1995-11-30',
                'age' => 29,
                'gender' => 'Female',
                'location' => 'San Francisco, USA',
                'about' => 'UX designer passionate about creating intuitive user experiences',
                'status' => 'block',
                'img' => 'default.jpg'
            ],
            [
                'unique_id' => 'USER005',
                'f_name' => 'David',
                'l_name' => 'Brown',
                'email' => 'david.brown@example.com',
                'phone' => '9876543214',
                'password' => Hash::make('password123'),
                'dob' => '1987-07-18',
                'age' => 37,
                'gender' => 'Male',
                'location' => 'Boston, USA',
                'about' => 'Project manager with PMP certification',
                'status' => 'block',
                'img' => 'default.jpg'
            ],
            [
                'unique_id' => 'USER006',
                'f_name' => 'Sarah',
                'l_name' => 'Davis',
                'email' => 'sarah.davis@example.com',
                'phone' => '9876543215',
                'password' => Hash::make('password123'),
                'dob' => '1993-12-05',
                'age' => 31,
                'gender' => 'Female',
                'location' => 'Seattle, USA',
                'about' => 'Frontend developer specializing in React and Vue.js',
                'status' => 'block',
                'img' => 'default.jpg'
            ],
            [
                'unique_id' => 'USER007',
                'f_name' => 'Robert',
                'l_name' => 'Miller',
                'email' => 'robert.miller@example.com',
                'phone' => '9876543216',
                'password' => Hash::make('password123'),
                'dob' => '1989-04-25',
                'age' => 35,
                'gender' => 'Male',
                'location' => 'Austin, USA',
                'about' => 'Backend developer with expertise in Laravel and Node.js',
                'status' => 'block',
                'img' => 'default.jpg'
            ],
            [
                'unique_id' => 'USER008',
                'f_name' => 'Lisa',
                'l_name' => 'Wilson',
                'email' => 'lisa.wilson@example.com',
                'phone' => '9876543217',
                'password' => Hash::make('password123'),
                'dob' => '1991-09-14',
                'age' => 33,
                'gender' => 'Female',
                'location' => 'Denver, USA',
                'about' => 'Product manager with experience in SaaS products',
                'status' => 'block',
                'img' => 'default.jpg'
            ],
            [
                'unique_id' => 'USER009',
                'f_name' => 'James',
                'l_name' => 'Taylor',
                'email' => 'james.taylor@example.com',
                'phone' => '9876543218',
                'password' => Hash::make('password123'),
                'dob' => '1994-06-08',
                'age' => 30,
                'gender' => 'Male',
                'location' => 'Miami, USA',
                'about' => 'DevOps engineer with AWS and Docker expertise',
                'status' => 'block',
                'img' => 'default.jpg'
            ],
            [
                'unique_id' => 'USER010',
                'f_name' => 'Maria',
                'l_name' => 'Anderson',
                'email' => 'maria.anderson@example.com',
                'phone' => '9876543219',
                'password' => Hash::make('password123'),
                'dob' => '1996-02-28',
                'age' => 28,
                'gender' => 'Female',
                'location' => 'Portland, USA',
                'about' => 'Full-stack developer with MERN stack experience',
                'status' => 'block',
                'img' => 'default.jpg'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
