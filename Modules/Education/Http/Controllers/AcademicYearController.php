<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Education\Entities\AcademicYear;
use Modules\Education\Http\Requests\AcademicYearRequest;
use Modules\Education\Repositories\AcademicYearRepository;
use Modules\Education\Transformers\AcademicYearResource;

class AcademicYearController extends \App\Http\Controllers\Controller
{
  protected AcademicYearRepository $repository;

  public function __construct(AcademicYearRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.academic-year.store')->only('store');
    $this->middleware('permission:education.academic-year.update')->only('update');
    $this->middleware('permission:education.academic-year.destroy')->only('destroy');
    $this->middleware('permission:education.academic-year.index')->only('index');
    $this->middleware('permission:education.academic-year.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return AcademicYearResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(AcademicYearRequest $request)
  {
    $data = $request->validated();

    $academicYear = $this->repository->create($data);

    return AcademicYearResource::make($academicYear);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $academicYear = $this->repository->find($id);

    return AcademicYearResource::make($academicYear);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(AcademicYearRequest $request, AcademicYear $academicYear)
  {
    $data = $request->validated();

    $academicYear = $this->repository->update($academicYear, $data);

    return AcademicYearResource::make($academicYear);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(AcademicYear $academicYear)
  {
    $this->repository->delete($academicYear);

    return response()->json([
      'success' => true,
      'message' => 'Academic Year deleted.',
    ]);
  }
}
