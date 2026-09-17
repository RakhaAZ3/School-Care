<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $roleAdmin = Role::where('name', 'admin')->first();

        // firstOrCreate: kalau email ini sudah ada, tidak dibuat ulang
        // (aman dijalankan berkali-kali tanpa error duplicate)
        User::firstOrCreate(
            ['email' => 'admin@sekolah.id'],
            [
                'role_id' => $roleAdmin?->id,
                'name' => 'Admin Sekolah',
                'password' => Hash::make('password123'),
            ]
        );
    }
}