<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\ClassroomType;
use Modules\Education\Http\Requests\ClassroomTypeRequest;
use Modules\Education\Repositories\ClassroomTypeRepository;
use Modules\Education\Transformers\ClassroomTypeResource;

class ClassroomTypeController extends \App\Http\Controllers\Controller
{
  protected ClassroomTypeRepository $repository;

  public function __construct(ClassroomTypeRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.classroom-type.store')->only('store');
    $this->middleware('permission:education.classroom-type.update')->only('update');
    $this->middleware('permission:education.classroom-type.destroy')->only('destroy');
    $this->middleware('permission:education.classroom-type.index')->only('index');
    $this->middleware('permission:education.classroom-type.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return ClassroomTypeResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ClassroomTypeRequest $request)
  {
    $data = $request->validated();

    $classroomType = $this->repository->create($data);

    return ClassroomTypeResource::make($classroomType);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $classroomType = $this->repository->find($id);

    return ClassroomTypeResource::make($classroomType);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ClassroomTypeRequest $request, ClassroomType $classroomType)
  {
    $data = $request->validated();

    $classroomType = $this->repository->update($classroomType, $data);

    return ClassroomTypeResource::make($classroomType);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(ClassroomType $classroomType)
  {
    $this->repository->delete($classroomType);

    return response()->json([
      'success' => true,
      'message' => 'Classroom Type deleted.',
    ]);
  }
}
