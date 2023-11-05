<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\AllowedInclude;

/**
 * @template T of \Spatie\Permission\Models\Role
 */
class RoleRepository extends BaseRepository
{
  public function model()
  {
    return Role::class;
  }

  public function allowedIncludes(): array
  {
    return [
      AllowedInclude::relationship('permissions')
    ];
  }

  public function allowedFields(): array
  {
    return [
      'id',
      'name',
      'guard_name',
      'permissions.name',
      'permissions.id'
    ];
  }
}
