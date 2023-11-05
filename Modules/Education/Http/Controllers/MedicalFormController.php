<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\MedicalForm;
use Modules\Education\Http\Requests\MedicalFormRequest;
use Modules\Education\Repositories\MedicalFormRepository;
use Modules\Education\Transformers\MedicalFormsResource;

class MedicalFormController extends Controller
{
  protected MedicalFormRepository $repository;

  public function __construct(MedicalFormRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.medical-form.index')->only('index');
    $this->middleware('permission:education.medical-form.show')->only('show');
    $this->middleware('permission:education.medical-form.store')->only('store');
    $this->middleware('permission:education.medical-form.update')->only('update');
    $this->middleware('permission:education.medical-form.destroy')->only('destroy');
  }

  public function index(Request $request)
  {
    return MedicalFormsResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  public function store(MedicalFormRequest $request)
  {
    $data = $request->validated();

    $medicalForm = $this->repository->create($data);

    return new MedicalFormsResource($medicalForm);
  }

  public function update(MedicalFormRequest $request, MedicalForm $medicalForm)
  {
    $data = $request->validated();

    $medicalForm = $this->repository->update($medicalForm, $data);

    return new MedicalFormsResource($medicalForm);
  }

  public function destroy(MedicalForm $medicalForm)
  {
    $this->repository->delete($medicalForm);

    return response()->json([
      'success' => true,
      'message' => 'Medical form deleted',
    ]);
  }

  public function show($id)
  {
    $medicalForm = $this->repository->find($id);

    return new MedicalFormsResource($medicalForm);
  }
}
