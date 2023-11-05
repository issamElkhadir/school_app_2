<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Period;
use Modules\Education\Http\Requests\PeriodRequest;
use Modules\Education\Repositories\PeriodRepository;
use Modules\Education\Transformers\PeriodResource;

class PeriodController extends \App\Http\Controllers\Controller
{
  protected PeriodRepository $repository;

  public function __construct(PeriodRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.period.store')->only('store');
    $this->middleware('permission:education.period.update')->only('update');
    $this->middleware('permission:education.period.destroy')->only('destroy');
    $this->middleware('permission:education.period.index')->only('index');
    $this->middleware('permission:education.period.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return PeriodResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(PeriodRequest $request)
  {
    $data = $request->validated();

    $period = $this->repository->create($data);

    return PeriodResource::make($period);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $period = $this->repository->find($id);

    return PeriodResource::make($period);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(PeriodRequest $request, Period $period)
  {
    $data = $request->validated();

    $period = $this->repository->update($period, $data);

    return PeriodResource::make($period);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Period $period)
  {
    $this->repository->delete($period);

    return response()->json([
      'success' => true,
      'message' => 'Period deleted.',
    ]);
  }
}
