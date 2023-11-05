<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\Doctor;
use Modules\Education\Http\Requests\DoctorRequest;
use Modules\Education\Repositories\DoctorRepository;
use Modules\Education\Transformers\DoctorResource;

class DoctorController extends Controller
{
  protected DoctorRepository $repository;

  public function __construct(DoctorRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.doctor.index')->only('index');
    $this->middleware('permission:education.doctor.show')->only('show');
    $this->middleware('permission:education.doctor.store')->only('store');
    $this->middleware('permission:education.doctor.update')->only('update');
    $this->middleware('permission:education.doctor.destroy')->only('destroy');
  }


  public function index(Request $request)
  {
    return DoctorResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  public function store(DoctorRequest $request)
  {
    $data = $request->validated();

    $doctor = $this->repository->create($data);

    return new DoctorResource($doctor);
  }

  public function update(DoctorRequest $request, Doctor $doctor)
  {
    $data = $request->validated();

    $doctor = $this->repository->update($doctor, $data);

    return new DoctorResource($doctor);
  }

  public function destroy(Doctor $doctor)
  {
    $this->repository->delete($doctor);

    return response()->json([
      'success' => true,
      'message' => 'Doctor deleted'
    ]);
  }

  public function show($id)
  {
    $doctor = $this->repository->find($id);

    return new DoctorResource($doctor);
  }
}
