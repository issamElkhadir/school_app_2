<?php

namespace App\Permissions;

use Illuminate\Support\Collection;

class PermissionDescriptor
{
  /**
   * The list of permissions.
   *
   * @var Collection<PermissionItem> $permissions
   */
  private Collection $permissions;

  public function __construct()
  {
    $this->permissions = collect([]);
  }

  public function inModule(string $module, \Closure $closure)
  {
    $closure(new PermissionBlueprint($this, $module, null));

    return $this;
  }

  public function forModel(string $module, string $model, \Closure $closure)
  {
    $closure(new PermissionBlueprint($this, $module, $model));

    return $this;
  }

  public static function make()
  {
    return new self();
  }

  public function add(string $module = null, string $model = null, string $name, string $label, string $guard = 'api'): static
  {
    $permission = new PermissionItem($module, $model, $name, $label, $guard);

    $this->permissions->add($permission);

    return $this;
  }

  public function toArray(): array
  {
    return $this->permissions->toArray();
  }
}
