<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
  use CreatesApplication;

  public function setUp(): void
  {
    parent::setUp();

    Permission::create(['name' => '*', 'display_name' => 'All', 'guard_name' => 'api']);

    $this->setUpSuperAdmin();
  }

  public function setUpSuperAdmin(): void
  {
    $user = User::factory()->create();

    $role = Role::create(['name' => 'Super Admin', 'guard_name' => 'api']);

    $role->givePermissionTo('*');

    $user->assignRole($role);
  }

  /**
   * @param array<string> $permissions
   */
  public function setUpUser(array $permissions = []): void
  {
    $user = User::factory()->create();

    $role = Role::create(['name' => 'User', 'guard_name' => 'api']);

    foreach ($permissions as $permission) {
      $permission = Permission::query()->firstOrCreate(['name' => $permission, 'display_name' => $permission, 'guard_name' => 'api']);

      $role->givePermissionTo($permission);
    }

    $user->assignRole($role);

    $this->actingAs($user, 'api');
  }
}
