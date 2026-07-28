<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    // public function run(): void
    // {

    //     DB::table('users')->insert([

    //         [
    //             'name' => 'Admin',
    //             'email' => 'admin@gmail.com',
    //             'password' => Hash::make('12345678'),
    //             'phone' => '0900000000',
    //             'address' => 'Hải Phòng',
    //             'is_active' => 3, // 👈 ADMIN
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],

    //         [
    //             'name' => 'User Test',
    //             'email' => 'user@gmail.com',
    //             'password' => Hash::make('12345678'),
    //             'phone' => '0900000001',
    //             'address' => 'Hà Nội',
    //             'is_active' => 1,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],

    //         [
    //             'name' => 'Nguyễn Văn A',
    //             'email' => 'a@gmail.com',
    //             'password' => Hash::make('123456'),
    //             'phone' => '0900000001',
    //             'address' => 'Hà Nội',
    //             'is_active' => 1,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],

    //         [
    //             'name' => 'Nguyễn Văn B',
    //             'email' => 'b@gmail.com',
    //             'password' => Hash::make('123456'),
    //             'phone' => '0900000002',
    //             'address' => 'Đà Nẵng',
    //             'is_active' => 1,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],

    //         [
    //             'name' => 'Nguyễn Văn C',
    //             'email' => 'c@gmail.com',
    //             'password' => Hash::make('123456'),
    //             'phone' => '0900000003',
    //             'address' => 'Hồ Chí Minh',
    //             'is_active' => 1,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],

    //         [
    //             'name' => 'Nguyễn Văn D',
    //             'email' => 'd@gmail.com',
    //             'password' => Hash::make('123456'),
    //             'phone' => '0900000004',
    //             'address' => 'Hải Phòng',
    //             'is_active' => 1,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],

    //         [
    //             'name' => 'Nguyễn Văn E',
    //             'email' => 'e@gmail.com',
    //             'password' => Hash::make('123456'),
    //             'phone' => '0900000005',
    //             'address' => 'Huế',
    //             'is_active' => 1,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],

    //     ]);
    // }

    public function run(): void
    {
        $users = [

            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'phone' => '0900000000',
                'address' => 'Hải Phòng',
                'is_active' => 3,
            ],

            [
                'name' => 'User Test',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12345678'),
                'phone' => '0900000001',
                'address' => 'Hà Nội',
                'is_active' => 1,
            ],

            [
                'name' => 'Nguyễn Văn A',
                'email' => 'a@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0900000001',
                'address' => 'Hà Nội',
                'is_active' => 1,
            ],

            [
                'name' => 'Nguyễn Văn B',
                'email' => 'b@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0900000002',
                'address' => 'Đà Nẵng',
                'is_active' => 1,
            ],

            [
                'name' => 'Nguyễn Văn C',
                'email' => 'c@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0900000003',
                'address' => 'Hồ Chí Minh',
                'is_active' => 1,
            ],

            [
                'name' => 'Nguyễn Văn D',
                'email' => 'd@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0900000004',
                'address' => 'Hải Phòng',
                'is_active' => 1,
            ],

            [
                'name' => 'Nguyễn Văn E',
                'email' => 'e@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0900000005',
                'address' => 'Huế',
                'is_active' => 1,
            ],

        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                [
                    'email' => $user['email'],
                ],
                $user
            );
        }
    }
}
