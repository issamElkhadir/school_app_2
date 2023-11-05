<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\AppointmentRequest;
use Modules\Education\Http\Requests\AppointmentRequestRequest;
use Modules\Education\Repositories\AppointmentRequestRepository;
use Modules\Education\Transformers\AppointmentRequestsResource;

class AppointmentRequestController extends Controller
{
  protected AppointmentRequestRepository $repository;

  public function __construct(AppointmentRequestRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.appointment-request.index')->only('index');
    $this->middleware('permission:education.appointment-request.show')->only('show');
    $this->middleware('permission:education.appointment-request.store')->only('store');
    $this->middleware('permission:education.appointment-request.update')->only('update');
    $this->middleware('permission:education.appointment-request.destroy')->only('destroy');
  }

  public function index(Request $request)
  {
    return AppointmentRequestsResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  public function store(AppointmentRequestRequest $request)
  {
    $data = $request->validated();

    $appointmentRequest = $this->repository->create($data);

    return new AppointmentRequestsResource($appointmentRequest);
  }

  public function update(AppointmentRequestRequest $request, AppointmentRequest $appointmentRequest)
  {
    $data = $request->validated();

    $appointmentRequest = $this->repository->update($appointmentRequest, $data);

    return new AppointmentRequestsResource($appointmentRequest);
  }

  public function destroy(AppointmentRequest $appointmentRequest)
  {
    $this->repository->delete($appointmentRequest);

    return response()->json([
      'success' => true,
      'message' => 'Appointment Request deleted',
    ]);
  }

  public function show($id)
  {
    $appointmentRequest = $this->repository->find($id);

    return new AppointmentRequestsResource($appointmentRequest);
  }
}
