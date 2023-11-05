<?php

namespace App\Http\Controllers;

use App\Http\Resources\MeasureUnitCategoryResource;
use App\Models\MeasureUnitCategory;
use App\Http\Requests\MeasureUnitCategoryRequest;
use App\Repositories\MeasureUnitCategoryRepository;
use Illuminate\Http\Request;

class MeasureUnitCategoryController extends Controller
{
  protected MeasureUnitCategoryRepository $repository;

  public function __construct(MeasureUnitCategoryRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:base.measure-unit-category.store')->only('store');
    $this->middleware('permission:base.measure-unit-category.update')->only('update');
    $this->middleware('permission:base.measure-unit-category.destroy')->only('destroy');
    $this->middleware('permission:base.measure-unit-category.index')->only('index');
    $this->middleware('permission:base.measure-unit-category.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return MeasureUnitCategoryResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(MeasureUnitCategoryRequest $request)
  {
    $attributes = $request->validated();

    $model = $this->repository->create($attributes);

    return MeasureUnitCategoryResource::make($model);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $category = $this->repository
      ->with(['units'])
      ->findOrFail($id);

    return MeasureUnitCategoryResource::make($category);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(MeasureUnitCategoryRequest $request, int $id)
  {
    $attributes = $request->validated();

    $model = $this->repository->update($id, $attributes);

    return MeasureUnitCategoryResource::make($model);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(MeasureUnitCategory $measureUnitCategory)
  {
    // Prevent deleting if there are some units
    if ($measureUnitCategory->units()->count() > 0) {
      return response()->json([
        'message' => 'Cannot delete measure unit category with units',
      ], 422);
    }

    $this->repository->delete($measureUnitCategory);

    return response()->noContent();
  }
}
