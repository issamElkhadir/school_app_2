<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Student;
use Modules\Education\Http\Requests\StudentRequest;
use Modules\Education\Repositories\StudentRepository;
use Modules\Education\Transformers\StudentResource;

class StudentController extends \App\Http\Controllers\Controller
{
  protected StudentRepository $repository;

  public function __construct(StudentRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.student.store')->only('store');
    $this->middleware('permission:education.student.update')->only('update');
    $this->middleware('permission:education.student.destroy')->only('destroy');
    $this->middleware('permission:education.student.index')->only('index');
    $this->middleware('permission:education.student.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return StudentResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StudentRequest $request)
  {
    $data = $request->validated();

    $student = $this->repository->create($data);

    return StudentResource::make($student);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $student = $this->repository->find($id);

    return StudentResource::make($student);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(StudentRequest $request, Student $student)
  {
    $data = $request->validated();

    $student = $this->repository->update($student, $data);

    return StudentResource::make($student);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Student $student)
  {
    $this->repository->delete($student);

    return response()->json([
      'success' => true,
      'message' => 'Student deleted.',
    ]);
  }
}
