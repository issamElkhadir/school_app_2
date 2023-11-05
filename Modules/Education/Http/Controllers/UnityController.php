<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Unity;
use Modules\Education\Http\Requests\UnityRequest;
use Modules\Education\Repositories\UnityRepository;
use Modules\Education\Transformers\UnityResource;

class UnityController extends \App\Http\Controllers\Controller
{
  protected UnityRepository $repository;

  public function __construct(UnityRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.unity.store')->only('store');
    $this->middleware('permission:education.unity.update')->only('update');
    $this->middleware('permission:education.unity.destroy')->only('destroy');
    $this->middleware('permission:education.unity.index')->only('index');
    $this->middleware('permission:education.unity.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return UnityResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(UnityRequest $request)
  {
    $data = $request->validated();

    $unity = $this->repository->create($data);

    return UnityResource::make($unity);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $unity = $this->repository->find($id);

    return UnityResource::make($unity);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UnityRequest $request, Unity $unity)
  {
    $data = $request->validated();

    $unity = $this->repository->update($unity, $data);

    return UnityResource::make($unity);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Unity $unity)
  {
    $this->repository->delete($unity);

    return response()->json([
      'success' => true,
      'message' => 'Unity deleted.',
    ]);
  }
}
