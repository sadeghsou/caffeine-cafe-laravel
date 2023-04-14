<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([[
            'name' => 'Mohammad',
            'mobile' => '09125446099',
            'password' => md5('Coffee@0062889311')
        ], [
            'name' => 'sadegh',
            'mobile' => '09129439150',
            'password' => md5('123')
        ]]);
    }
}
