<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $data = [
    [
        'level_id' => 1, 
        'username' => 'admin',
        'nama' => 'Administrator',
        'password' => Hash::make('12345'),
        'created_at' => NOW()
    ],
    [
        'level_id' => 2, 
        'username' => 'manager',
        'nama' => 'Manager',
        'password' => Hash::make('12345'),
        'created_at' => NOW()
    ],
    [
        'level_id' => 3, 
        'username' => 'staff',
        'nama' => 'Staff/Kasir',
        'password' => Hash::make('12345'),
        'created_at' => NOW()
    ]
];


        DB::table('m_user')->insert($data);
    }
}
