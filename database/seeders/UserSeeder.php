<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Yuri',
            'email' => 'yurirene@gmail.com',
            'password' => Hash::make('123'),
            'is_admin' => true,
            'sinodal' => false,
        ]);

        User::create([
            'name' => 'Yuri Ferreira',
            'email' => 'yuri.ferreira@superlogica.com',
            'password' => Hash::make('123'),
            'is_admin' => false,
            'sinodal' => true,
            'email_verified_at' => now(),
            'tenant_id' => 'b3201496-329d-43b4-82ba-8ead42f25b1f',
        ]);
    }
}
