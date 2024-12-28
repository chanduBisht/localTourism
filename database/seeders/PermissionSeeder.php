<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        #Role
        Permission::firstOrCreate(['name' => 'View All Roles']);
        Permission::firstOrCreate(['name' => 'Add Roles']);
        Permission::firstOrCreate(['name' => 'Edit Roles']);

        Permission::firstOrCreate(['name' => 'View Dashboard']);

        Permission::firstOrCreate(['name' => 'View Permissions']);
        Permission::firstOrCreate(['name' => 'Add Permissions']);

        Permission::firstOrCreate(['name' => 'View Place']);
        Permission::firstOrCreate(['name' => 'Add Place']);
        Permission::firstOrCreate(['name' => 'Edit Place']);
        Permission::firstOrCreate(['name' => 'Delete Place']);

        Permission::firstOrCreate(['name' => 'Add Hotel']);
        Permission::firstOrCreate(['name' => 'View Hotel']);
        Permission::firstOrCreate(['name' => 'Edit Hotel']);
        Permission::firstOrCreate(['name' => 'Delete Hotel']);

        Permission::firstOrCreate(['name' => 'View Room']);
        Permission::firstOrCreate(['name' => 'Add Room']);
        Permission::firstOrCreate(['name' => 'Edit Room']);
        Permission::firstOrCreate(['name' => 'Delete Room']);

        Permission::firstOrCreate(['name' => 'View Taxi']);
        Permission::firstOrCreate(['name' => 'Add Taxi']);
        Permission::firstOrCreate(['name' => 'Edit Taxi']);
        Permission::firstOrCreate(['name' => 'Delete Taxi']);

        Permission::firstOrCreate(['name' => 'View Traking']);
        Permission::firstOrCreate(['name' => 'Add Traking']);
        Permission::firstOrCreate(['name' => 'Edit Traking']);
        Permission::firstOrCreate(['name' => 'Delete Traking']);
    }
}
