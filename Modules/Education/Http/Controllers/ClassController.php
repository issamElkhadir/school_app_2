<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Clazz;
use Modules\Education\Http\Requests\ClassRequest;
use Modules\Education\Repositories\ClassRepository;
use Modules\Education\Transformers\ClassResource;

class ClassController extends \App\Http\Controllers\Controller
{
  protected ClassRepository $repository;

  public function __construct(ClassRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.class.store')->only('store');
    $this->middleware('permission:education.class.update')->only('update');
    $this->middleware('permission:education.class.destroy')->only('destroy');
    $this->middleware('permission:education.class.index')->only('index');
    $this->middleware('permission:education.class.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return ClassResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ClassRequest $request)
  {
    $data = $request->validated();

    $class = $this->repository->create($data);

    return ClassResource::make($class);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $class = $this->repository->find($id);

    return ClassResource::make($class);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ClassRequest $request, Clazz $class)
  {
    $data = $request->validated();

    $class = $this->repository->update($class, $data);

    return ClassResource::make($class);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Clazz $class)
  {
    $this->repository->delete($class);

    return response()->json([
      'success' => true,
      'message' => 'Class deleted.',
    ]);
  }
}
