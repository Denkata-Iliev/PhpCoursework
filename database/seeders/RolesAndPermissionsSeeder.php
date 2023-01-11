<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Seed roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // clear package's cache (recommended in docs)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        if (DB::table('permissions')->count() !== 0) {
            return;
        }
        // create permissions
        Permission::create(['name' => 'access-users']);
        Permission::create(['name' => 'access-rooms']);
        Permission::create(['name' => 'access-rooms-crud']);

        if (DB::table('roles')->count() !== 0) {
            return;
        }
        // create ADMIN role and give it all permissions
        $admin = Role::create(['name' => 'ADMIN']);
        $admin->givePermissionTo(Permission::all());

        // create USER role and give it only access to rooms
        $user = Role::create(['name' => 'USER']);
        $user->givePermissionTo('access-rooms');
    }
}
