<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'Admin'])->givePermissionTo(Permission::all());

        $user = User::create([
            'name' => 'Admin',
            'email' => 'localtourism@gmail.com',
            'password' => Hash::make('admin@123!'),
            'phone' => '8077013392',
            'role'=>$role->id,
            'status'=>1,
        ]);

        $user->assignRole($role);

        Role::create(['name' => 'User']);
        Role::create(['name' => 'Hotel']);
        Role::create(['name' => 'Taxi']);

    }
}
