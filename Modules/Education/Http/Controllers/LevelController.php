<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Level;
use Modules\Education\Http\Requests\LevelRequest;
use Modules\Education\Repositories\LevelRepository;
use Modules\Education\Transformers\LevelResource;

class LevelController extends \App\Http\Controllers\Controller
{
  protected LevelRepository $repository;

  public function __construct(LevelRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.level.store')->only('store');
    $this->middleware('permission:education.level.update')->only('update');
    $this->middleware('permission:education.level.destroy')->only('destroy');
    $this->middleware('permission:education.level.index')->only('index');
    $this->middleware('permission:education.level.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return LevelResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(LevelRequest $request)
  {
    $data = $request->validated();

    $level = $this->repository->create($data);

    return LevelResource::make($level);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $level = $this->repository->find($id);

    return LevelResource::make($level);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(LevelRequest $request, Level $level)
  {
    $data = $request->validated();

    $level = $this->repository->update($level, $data);

    return LevelResource::make($level);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Level $level)
  {
    $this->repository->delete($level);

    return response()->json([
      'success' => true,
      'message' => 'Level deleted.',
    ]);
  }
}
