<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Http\Requests\CurrencyRequest;
use Illuminate\Http\Request;
use App\Http\Resources\CurrencyResource;
use App\Repositories\CurrencyRepository;

class CurrencyController extends Controller
{
  protected CurrencyRepository $repository;

  public function __construct(CurrencyRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:base.currency.store')->only('store');
    $this->middleware('permission:base.currency.update')->only('update');
    $this->middleware('permission:base.currency.destroy')->only('destroy');
    $this->middleware('permission:base.currency.index')->only('index');
    $this->middleware('permission:base.currency.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return CurrencyResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CurrencyRequest $request)
  {
    $currency = $this->repository->create($request->validated());

    return CurrencyResource::make($currency);
  }

  /**
   * Display the specified resource.
   */
  public function show(Currency $currency)
  {
    return CurrencyResource::make($currency);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CurrencyRequest $request, Currency $currency)
  {
    $currency = $this->repository->update($currency, $request->validated());

    return CurrencyResource::make($currency);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Currency $currency)
  {
    $this->repository->delete($currency);

    return response()->noContent();
  }
}
