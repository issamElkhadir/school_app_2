<?php

namespace Database\Seeders;

use App\Permissions\PermissionDescriptor;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
  protected static array $permissionPathes = [
    'database/data/permissions.php'
  ];

  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Clear cached permissions
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    // Truncate all permission
    Permission::truncate();

    foreach (self::$permissionPathes as $path) {
      $descriptor = require $path;

      if ($descriptor instanceof PermissionDescriptor) {
        $permissions = $descriptor->toArray();

        foreach ($permissions as $permission) {
          Permission::create($permission->toArray());
        }
      } else {
        throw new \Exception('The permission descriptor file must return an instance of ' . PermissionDescriptor::class);
      }
    }
  }

  public static function addPermissionPath(string $path): void
  {
    self::$permissionPathes[] = $path;
  }
}
