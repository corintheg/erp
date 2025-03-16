<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'user'],
            ['name' => 'rh'],
            ['name' => 'manager'],
        ]);
    }
}

