<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        DB::table('roles')->delete();

        // Buat role sesuai kebutuhan SOP
        Role::create(['name' => 'hrga']);
        Role::create(['name' => 'koki']);
        Role::create(['name' => 'karyawan']);
    }
}