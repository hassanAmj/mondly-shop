<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Role;
use App\Models\Permission;



class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_can_have_permissions():void{

        $role = Role::create([
            'name' => 'admin',
        ]);

        $permission = Permission::create([
            'name' => 'create_product',
        ]);

        $role->permissions()->attach($permission);

        $this->assertTrue(
            $role->permissions->contains($permission)
        );
    }

    public function test_permission_can_have_roles():void{
        $role = Role::create([
            'name' => 'admin',
        ]);

        $permission = Permission::create([
            'name' => 'create_product',
        ]);

        $permission->roles()->attach($role);

        $this->assertTrue(
            $permission->roles->contains($role)
        );
    }
    
}
