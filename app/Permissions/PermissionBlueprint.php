<?php

namespace App\Permissions;

class PermissionBlueprint
{
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

  /**
   * The permission instance.
   *
   * @var PermissionDescriptor $descriptor
   */
  private PermissionDescriptor $descriptor;

  public function __construct(PermissionDescriptor $descriptor, string|null $module = null, string|null $model = null)
  {
    $this->module = $module;

    $this->model = $model;

    $this->descriptor = $descriptor;
  }

  /**
   * Add permissions in the model.
   *
   * @param string $model The model name.
   * @param \Closure(self $blueprint): void $closure The closure to add permissions.
   * @return void
   */
  public function forModel(string $model, \Closure $closure)
  {
    $closure(new self($this->descriptor, $this->module, $model));
  }

  public function add(string $name, string $label, string $guard = 'api', bool $qualify = true): PermissionDescriptor
  {
    if ($qualify) {
      $name = $this->prependWithModuleAndModel($name);
    }

    return $this->descriptor->add($this->module, $this->model, $name, $label, $guard);
  }

  private function prependWithModuleAndModel(string $name): string
  {
    if (isset($this->module)) {
      $module = strtolower($this->module);

      if (isset($this->model)) {
        $modelName = \Str::kebab(class_basename($this->model));

        $name = "{$module}.{$modelName}.{$name}";
      } else {
        $name = "{$module}.{$name}";
      }
    }

    return $name;
  }
}
