<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Nwidart\Modules\Facades\Module;

/** @mixin \Spatie\Permission\Models\Permission  */
class PermissionResource extends ResourceCollection
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    $collection = [];

    foreach ($this->collection as $permission) {
      $moduleName = $permission->module ?? 'base';

      $moduleLabel = Module::find($permission->module)?->getName() ?? 'Base';

      $modelName = \Str::of($permission->model)
        ->classBasename()
        ->kebab()
        ->toString();

      $modelLabel = \Str::of($modelName)->replace('-', ' ')->title();

      if (!isset($collection[$moduleName])) {
        $collection[$moduleName] = [
          'name' => $moduleName,
          'label' => $moduleLabel,
          'resources' => [],
        ];
      }

      if (!isset($collection[$moduleName]['resources'][$modelName])) {
        $collection[$moduleName]['resources'][$modelName] = [
          'name' => $modelName,
          'label' => $modelLabel,
          'permissions' => [],
        ];
      }

      $collection[$moduleName]['resources'][$modelName]['permissions'][] = [
        'name' => $permission->name,
        'label' => $permission->display_name,
      ];
    }

    foreach($collection as $module => $values) {
      $collection[$module]['resources'] = array_values($values['resources']);
    }

    return $collection;
  }
}
