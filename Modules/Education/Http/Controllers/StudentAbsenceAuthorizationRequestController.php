<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Education\Entities\StudentAbsenceAuthorizationRequest;
use Modules\Education\Http\Requests\StudentAbsenceAuthorizationRequestRequest;
use Modules\Education\Repositories\StudentAbsenceAuthorizationRequestRepository;
use Modules\Education\Transformers\StudentAbsenceAuthorizationRequestResource;

class StudentAbsenceAuthorizationRequestController extends Controller
{
  protected StudentAbsenceAuthorizationRequestRepository $repository;

  public function __construct(StudentAbsenceAuthorizationRequestRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.student-absence-authorization-request.store')->only('store');
    $this->middleware('permission:education.student-absence-authorization-request.update')->only('update');
    $this->middleware('permission:education.student-absence-authorization-request.destroy')->only('destroy');
    $this->middleware('permission:education.student-absence-authorization-request.index')->only('index');
    $this->middleware('permission:education.student-absence-authorization-request.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return StudentAbsenceAuthorizationRequestResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StudentAbsenceAuthorizationRequestRequest $request)
  {
    $data = $request->validated();

    $studentAbsenceAuthorizationRequest = $this->repository->create($data);

    return StudentAbsenceAuthorizationRequestResource::make($studentAbsenceAuthorizationRequest);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $studentAbsenceAuthorizationRequest = $this->repository->find($id);

    return new StudentAbsenceAuthorizationRequestResource($studentAbsenceAuthorizationRequest);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(StudentAbsenceAuthorizationRequestRequest $request, StudentAbsenceAuthorizationRequest $studentAbsenceAuthorizationRequest)
  {
    $data = $request->validated();

    $studentAbsenceAuthorizationRequest = $this->repository
      ->update($studentAbsenceAuthorizationRequest, $data);

    return new StudentAbsenceAuthorizationRequestResource($studentAbsenceAuthorizationRequest);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(StudentAbsenceAuthorizationRequest $studentAbsenceAuthorizationRequest)
  {
    $this->repository->delete($studentAbsenceAuthorizationRequest);

    return response()->json([
      'success' => true,
      'message' => 'student absence authorization request deleted.',
    ]);
  }
}
