<?php

namespace App\Http\Controllers;

use App\Http\Resources\SequenceResource;
use App\Models\Sequence;
use App\Http\Requests\SequenceRequest;
use App\Repositories\SequenceRepository;

class SequenceController extends Controller
{
  protected SequenceRepository $repository;

  public function __construct(SequenceRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:base.sequence.store')->only('store');
    $this->middleware('permission:base.sequence.update')->only('update');
    $this->middleware('permission:base.sequence.destroy')->only('destroy');
    $this->middleware('permission:base.sequence.index')->only('index');
    $this->middleware('permission:base.sequence.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return SequenceResource::collection(
      $this->paginate(request(), $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(SequenceRequest $request)
  {
    $data = $request->validated();

    $sequence = $this->repository->create($data);

    return SequenceResource::make($sequence);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $model = $this->repository->findOrFail($id);

    return SequenceResource::make($model);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(SequenceRequest $request, Sequence $sequence)
  {
    $data = $request->validated();

    $sequence = $this->repository->update($sequence, $data);

    return SequenceResource::make($sequence);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Sequence $sequence)
  {
    $this->repository->delete($sequence);

    return response()->noContent();
  }
}
