<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'label' => 'Admin'],
            ['name' => 'guru', 'label' => 'Guru/Pegawai'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}