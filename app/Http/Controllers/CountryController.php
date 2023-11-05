<?php

namespace App\Http\Controllers;

use App\Exports\CountriesExport;
use App\Http\Requests\CountryRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;

class CountryController extends Controller
{
  use ExportableResource;

  protected CountryRepository $repository;

  public function __construct(CountryRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:base.country.store')->only('store');
    $this->middleware('permission:base.country.update')->only('update');
    $this->middleware('permission:base.country.destroy')->only('destroy');
    $this->middleware('permission:base.country.index')->only('index');
    $this->middleware('permission:base.country.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return CountryResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CountryRequest $request)
  {
    $data = $request->validated();

    $country = $this->repository->create($data);

    return CountryResource::make($country);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $country = $this->repository->findOrFail($id);

    return CountryResource::make($country);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CountryRequest $request, Country $country)
  {
    $data = $request->validated();

    $country = $this->repository->update($country, $data);

    return CountryResource::make($country);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Country $country)
  {
    // Prevent deleting country if it has states.
    if ($country->states()->exists()) {
      return response()->json([
        'success' => false,
        'message' => 'Country has states.',
      ]);
    }

    $this->repository->delete($country);

    return response()->json([
      'success' => true,
      'message' => 'Country deleted.',
    ]);
  }

  public function exporter(): string
  {
    return CountriesExport::class;
  }
}
