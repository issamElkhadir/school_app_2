<?php

namespace App\Http\Controllers;

use App\Http\Resources\MeasureUnitResource;
use App\Http\Requests\MeasureUnitRequest;
use App\Repositories\MeasureUnitRepository;
use Illuminate\Http\Request;

class MeasureUnitController extends Controller
{
  protected MeasureUnitRepository $repository;

  public function __construct(MeasureUnitRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:base.measure-unit.store')->only('store');
    $this->middleware('permission:base.measure-unit.update')->only('update');
    $this->middleware('permission:base.measure-unit.destroy')->only('destroy');
    $this->middleware('permission:base.measure-unit.index')->only('index');
    $this->middleware('permission:base.measure-unit.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return MeasureUnitResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(MeasureUnitRequest $request)
  {
    $attributes = $request->validated();

    $model = $this->repository->create($attributes);

    return MeasureUnitResource::make($model);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $measureUnit = $this->repository->findOrFail($id);

    return MeasureUnitResource::make($measureUnit);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(MeasureUnitRequest $request, int $id)
  {
    $measureUnit = $this->repository->findOrFail($id);

    $attributes = $request->validated();

    $model = $this->repository->update($measureUnit, $attributes);

    return MeasureUnitResource::make($model);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(int $id)
  {
    $measureUnit = $this->repository->findOrFail($id);

    $this->repository->delete($measureUnit);

    return response()->noContent();
  }
}
