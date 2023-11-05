<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Repositories\RoleRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
  protected RoleRepository $repository;

  public function __construct(RoleRepository $repository)
  {
    $this->repository = $repository;
  }

  /**
   * Get all roles without pagination
   *
   * @return AnonymousResourceCollection
   */
  public function all(): AnonymousResourceCollection
  {
    $roles = $this->repository->get();

    return RoleResource::collection($roles);
  }
}
