<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Education\Entities\StudentAuthorizationRequest;
use Modules\Education\Http\Requests\StudentAuthorizationRequestRequest;
use Modules\Education\Repositories\StudentAuthorizationRequestRepository;
use Modules\Education\Transformers\StudentAuthorizationRequestResource;

class StudentAuthorizationRequestController extends Controller
{
  protected StudentAuthorizationRequestRepository $repository;

  public function __construct(StudentAuthorizationRequestRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.student-authorization-request.store')->only('store');
    $this->middleware('permission:education.student-authorization-request.update')->only('update');
    $this->middleware('permission:education.student-authorization-request.destroy')->only('destroy');
    $this->middleware('permission:education.student-authorization-request.index')->only('index');
    $this->middleware('permission:education.student-authorization-request.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return StudentAuthorizationRequestResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StudentAuthorizationRequestRequest $request)
  {
    $data = $request->validated();

    $studentAuthorizationRequest = $this->repository->create($data);

    return StudentAuthorizationRequestResource::make($studentAuthorizationRequest);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $studentAuthorizationRequest = $this->repository->find($id);

    return new StudentAuthorizationRequestResource($studentAuthorizationRequest);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(StudentAuthorizationRequestRequest $request, StudentAuthorizationRequest $studentAuthorizationRequest)
  {
    $data = $request->validated();

    $studentAuthorizationRequest = $this->repository->update($studentAuthorizationRequest, $data);

    return new StudentAuthorizationRequestResource($studentAuthorizationRequest);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(StudentAuthorizationRequest $studentAuthorizationRequest)
  {
    $this->repository->delete($studentAuthorizationRequest);

    return response()->json([
      'success' => true,
      'message' => 'student authorization request deleted.',
    ]);
  }
}
