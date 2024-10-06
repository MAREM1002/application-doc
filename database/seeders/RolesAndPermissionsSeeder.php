<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Créer des permissions
        $writePermission = Permission::create(['name' => 'write articles']);
        $readPermission = Permission::create(['name' => 'read articles']);
        $createPermission = Permission::create(['name' => 'create articles']);

        // Créer des rôles
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);

        // Assigner les permissions aux rôles
        $adminRole->givePermissionTo([$writePermission, $readPermission, $createPermission]);
        $editorRole->givePermissionTo([$readPermission, $createPermission]);

        // Assigner un rôle à un utilisateur (exemple avec ID 1)
        $user = \App\Models\User::find(1);
        $user->assignRole('admin');
    }
}
