<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Cycle;
use Modules\Education\Http\Requests\CycleRequest;
use Modules\Education\Repositories\CycleRepository;
use Modules\Education\Transformers\CycleResource;

class CycleController extends \App\Http\Controllers\Controller
{
  protected CycleRepository $repository;

  public function __construct(CycleRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.cycle.store')->only('store');
    $this->middleware('permission:education.cycle.update')->only('update');
    $this->middleware('permission:education.cycle.destroy')->only('destroy');
    $this->middleware('permission:education.cycle.index')->only('index');
    $this->middleware('permission:education.cycle.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return CycleResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CycleRequest $request)
  {
    $data = $request->validated();

    $cycle = $this->repository->create($data);

    return CycleResource::make($cycle);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $cycle = $this->repository->find($id);

    return CycleResource::make($cycle);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CycleRequest $request, Cycle $cycle)
  {
    $data = $request->validated();

    $cycle = $this->repository->update($cycle, $data);

    return CycleResource::make($cycle);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Cycle $cycle)
  {
    $this->repository->delete($cycle);

    return response()->json([
      'success' => true,
      'message' => 'Cycle deleted.',
    ]);
  }
}
