<?php

namespace App\Http\Controllers;

use App\Exports\CitiesExport;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Http\Resources\CityResource;
use App\Repositories\CityRepository;
use Illuminate\Http\Request;

class CityController extends Controller
{
  use ExportableResource;

  protected CityRepository $repository;

  public function __construct(CityRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:base.city.store')->only('store');
    $this->middleware('permission:base.city.update')->only('update');
    $this->middleware('permission:base.city.destroy')->only('destroy');
    $this->middleware('permission:base.city.index')->only('index');
    $this->middleware('permission:base.city.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return CityResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CityRequest $request)
  {
    $data = $request->validated();

    $city = $this->repository->create($data);

    return CityResource::make($city);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $city = $this->repository->find($id);

    return CityResource::make($city);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CityRequest $request, City $city)
  {
    $data = $request->validated();

    $city = $this->repository->update($city, $data);

    return CityResource::make($city);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(City $city)
  {
    $this->repository->delete($city);

    return response()->json([
      'success' => true,
      'message' => 'City deleted.',
    ]);
  }

  public function exporter(): string
  {
    return CitiesExport::class;
  }
}
