<?php

namespace App\Http\Controllers;

use App\Exports\StatesExport;
use App\Models\State;
use App\Http\Requests\StateRequest;
use App\Http\Resources\StateResource;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;

class StateController extends Controller
{
  use ExportableResource;

  protected StateRepository $repository;

  public function __construct(StateRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:base.state.store')->only('store');
    $this->middleware('permission:base.state.update')->only('update');
    $this->middleware('permission:base.state.destroy')->only('destroy');
    $this->middleware('permission:base.state.index')->only('index');
    $this->middleware('permission:base.state.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return StateResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StateRequest $request)
  {
    $data = $request->validated();

    $state = $this->repository->create($data);

    return StateResource::make($state);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $state = $this->repository->find($id);

    return StateResource::make($state);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(StateRequest $request, State $state)
  {
    $data = $request->validated();

    $state = $this->repository->update($state, $data);

    return StateResource::make($state);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(State $state)
  {
    // Prevent deleting state if it has cities.
    if ($state->cities()->exists()) {
      return response()->json([
        'success' => false,
        'message' => 'State has cities.',
      ]);
    }

    $this->repository->delete($state);

    return response()->json([
      'success' => true,
      'message' => 'State deleted.',
    ]);
  }

  public function exporter(): string
  {
    return StatesExport::class;
  }
}
