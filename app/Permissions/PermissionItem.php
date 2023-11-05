<?php

namespace App\Permissions;

class PermissionItem
{
  /**
   * The name of the permission.
   *
   * @var string $name
   */
  private string $name;

  /**
   * The display name of the permission.
   *
   * @var string $label
   */
  private string $label;

  /**
   * The guard name of the permission.
   *
   * @var string $guard
   */
  private string $guard;

  /**
   * The module of the permission.
   *
   * @var string|null $module
   */
  private string|null $module;

  /**
   * The model of the permission.
   *
   * @var string|null $model
   */
  private string|null $model;

  public function __construct(string $module = null, string $model = null, string $name, string $label, string $guard = 'api')
  {
    $this->module = $module;

    $this->model = $model;

    $this->name = $name;

    $this->label = $label;

    $this->guard = $guard;
  }

  public function toArray(): array
  {
    return [
      'name' => $this->name,
      'display_name' => $this->label,
      'guard_name' => $this->guard,
      'module' => $this->module,
      'model' => $this->model
    ];
  }
}
