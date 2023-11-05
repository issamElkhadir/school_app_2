<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserDefinedFilterResource;
use App\Http\Requests\UserDefinedFilterRequest;
use App\Repositories\UserDefinedFilterRepository;
use Illuminate\Http\Request;

class UserDefinedFilterController extends Controller
{
  protected UserDefinedFilterRepository $repository;

  public function __construct(UserDefinedFilterRepository $repository)
  {
    $this->repository = $repository;

    $this->repository->whereUserId(auth()->id());
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return UserDefinedFilterResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(UserDefinedFilterRequest $request)
  {
    $userDefinedFilter = $this->repository->create([
      'name' => $request->name,
      'filters' => $request->filters,
      'description' => $request->description,
      'is_default' => $request->is_default,
      'is_enabled' => $request->is_enabled,
      'qualified_model_name' => $request->qualifyModel(),
      'model' => $request->model,
      'user_id' => auth()->id(),
    ]);

    return UserDefinedFilterResource::make($userDefinedFilter);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    return UserDefinedFilterResource::make($this->repository->findOrFail($id));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UserDefinedFilterRequest $request, int $id)
  {
    $userDefinedFilter = $this->repository->findOrFail($id);

    $userDefinedFilter->update([
      'name' => $request->name,
      'filters' => $request->filters,
      'description' => $request->description,
      'is_default' => $request->is_default,
      'is_enabled' => $request->is_enabled,
      'qualified_model_name' => $request->qualifyModel(),
      'model' => $request->model,
    ]);

    return UserDefinedFilterResource::make($userDefinedFilter);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(int $id)
  {
    $userDefinedFilter = $this->repository->findOrFail($id);

    $userDefinedFilter->delete();

    return response()->noContent();
  }
}
