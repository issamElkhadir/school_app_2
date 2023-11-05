<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Classroom;
use Modules\Education\Http\Requests\ClassroomRequest;
use Modules\Education\Repositories\ClassroomRepository;
use Modules\Education\Transformers\ClassroomResource;

class ClassroomController extends \App\Http\Controllers\Controller
{
  protected ClassroomRepository $repository;

  public function __construct(ClassroomRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.classroom.store')->only('store');
    $this->middleware('permission:education.classroom.update')->only('update');
    $this->middleware('permission:education.classroom.destroy')->only('destroy');
    $this->middleware('permission:education.classroom.index')->only('index');
    $this->middleware('permission:education.classroom.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return ClassroomResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ClassroomRequest $request)
  {
    $data = $request->validated();

    $classroom = $this->repository->create($data);

    return ClassroomResource::make($classroom);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $classroom = $this->repository->find($id);

    return ClassroomResource::make($classroom);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ClassroomRequest $request, Classroom $classroom)
  {
    $data = $request->validated();

    $classroom = $this->repository->update($classroom, $data);

    return ClassroomResource::make($classroom);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Classroom $classroom)
  {
    $this->repository->delete($classroom);

    return response()->json([
      'success' => true,
      'message' => 'Classroom deleted.',
    ]);
  }
}
