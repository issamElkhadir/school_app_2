<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\StaffAuthorizationRequest;
use Modules\Education\Http\Requests\StaffAuthorizationRequestRequest;
use Modules\Education\Repositories\StaffAuthorizationRequestRepository;
use Modules\Education\Transformers\StaffAuthorizationRequestResource;

class StaffAuthorizationRequestController extends Controller
{
  protected StaffAuthorizationRequestRepository $repository;
  public function __construct(StaffAuthorizationRequestRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.staff-authorization-request.store')->only('store');
    $this->middleware('permission:education.staff-authorization-request.update')->only('update');
    $this->middleware('permission:education.staff-authorization-request.destroy')->only('destroy');
    $this->middleware('permission:education.staff-authorization-request.index')->only('index');
    $this->middleware('permission:education.staff-authorization-request.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return StaffAuthorizationRequestResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StaffAuthorizationRequestRequest $request)
  {
    $data = $request->validated();

    $staffAuthorizationRequest = $this->repository->create($data);

    return StaffAuthorizationRequestResource::make($staffAuthorizationRequest);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $staffAuthorizationRequest = $this->repository->find($id);

    return new StaffAuthorizationRequestResource($staffAuthorizationRequest);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(StaffAuthorizationRequestRequest $request, StaffAuthorizationRequest $staffAuthorizationRequest)
  {
    $data = $request->validated();

    $staffAuthorizationRequest = $this->repository->update($staffAuthorizationRequest, $data);

    return new StaffAuthorizationRequestResource($staffAuthorizationRequest);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(StaffAuthorizationRequest $staffAuthorizationRequest)
  {
    $this->repository->delete($staffAuthorizationRequest);

    return response()->json([
      'success' => true,
      'message' => 'staff authorization request deleted.',
    ]);
  }

}
