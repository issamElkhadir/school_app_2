<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Education\Entities\AbsenceType;
use Modules\Education\Http\Requests\AbsenceTypeRequest;
use Modules\Education\Repositories\AbsenceTypeRepository;
use Modules\Education\Transformers\AbsenceTypeResource;

class AbsenceTypeController extends Controller
{
  protected AbsenceTypeRepository $repository ;
    public function __construct(AbsenceTypeRepository $repository)
    {
        $this->repository = $repository;

        $this->middleware('permission:education.absence-types.index')->only('index');
        $this->middleware('permission:education.absence-types.show')->only('show');
        $this->middleware('permission:education.absence-types.store')->only('store');
        $this->middleware('permission:education.absence-types.update')->only('update');
        $this->middleware('permission:education.absence-types.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        return AbsenceTypeResource::collection(
            $this->paginate($request, $this->repository)
        );
    }

    public function store(AbsenceTypeRequest $request)
    {
        $data = $request->validated();

        $absenceType = $this->repository->create($data);

        return new AbsenceTypeResource($absenceType);
    }

    public function update(AbsenceTypeRequest $request, AbsenceType $absenceType)
    {
        $data = $request->validated();

        $absenceType = $this->repository->update($absenceType, $data);

        return new AbsenceTypeResource($absenceType);
    }

    public function destroy(AbsenceType $absenceType)
    {
        $this->repository->delete($absenceType);

        return response()->json([
            'success' => true,
            'message' => 'absence type deleted',
        ]);
    }

    public function show($id)
    {
        $absenceType = $this->repository->find($id);

        return new AbsenceTypeResource($absenceType);
    }
}
