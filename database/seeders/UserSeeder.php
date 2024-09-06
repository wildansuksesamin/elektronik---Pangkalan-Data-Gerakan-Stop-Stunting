<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // admin
            [
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'status' => 1,
                'role' => 'Admin'
            ],
            [
                'id' => 2,
                'username' => 'surveyor1',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'status' => 1,
                'role' => 'Surveyor'
            ],
            [
                'id' => 3,
                'username' => 'surveyor2',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'status' => 2,
                'role' => 'Surveyor'
            ],
            [
                'id' => 4,
                'username' => 'surveyor3',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'status' => 1,
                'role' => 'Surveyor'
            ],
            [
                'id' => 5,
                'username' => 'surveyor4',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'status' => 1,
                'role' => 'Surveyor'
            ],
           
        ];
        
        DB::table('users')->insert($data);
    }
}
