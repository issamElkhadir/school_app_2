<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\JsonResponse;

class PermissionController extends Controller
{
  public function all(): PermissionResource
  {
    // Exclude permissions that are not related to a model or module
    $permissions = Permission::query()
      ->whereNotNull(['module', 'model'])
      ->get();

    return PermissionResource::make($permissions);
  }

  public function update(Request $request): JsonResponse
  {
    try {
      $request->validate([
        '*.role.id' => 'exists:roles,id'
      ]);

      \DB::beginTransaction();

      $roles = $request->input('*.role.id');

      foreach ($roles as $id) {
        $role = Role::findById($id);

        $role->syncPermissions($request->input('*.role.permissions'));
      }

      \DB::commit();

      return response()->json([
        'message' => 'Permissions updated successfully'
      ]);
    } catch (\Throwable $th) {
      \DB::rollBack();

      return response()->json([
        'message' => 'Something went wrong',
        'details' => app()->isProduction() ? null : $th->getMessage()
      ], 500);
    }
  }
}
