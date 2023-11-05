<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Education\Entities\Absence;
use Modules\Education\Http\Requests\AbsenceRequest;
use Modules\Education\Repositories\AbsenceRepository;
use Modules\Education\Transformers\AbsenceResource;

class AbsenceController extends Controller
{
    protected AbsenceRepository $repository ;
    public function __construct(AbsenceRepository $repository)
    {
        $this->repository = $repository;

        $this->middleware('permission:education.absence.index')->only('index');
        $this->middleware('permission:education.absence.show')->only('show');
        $this->middleware('permission:education.absence.store')->only('store');
        $this->middleware('permission:education.absence.update')->only('update');
        $this->middleware('permission:education.absence.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        return AbsenceResource::collection(
            $this->paginate($request, $this->repository)
        );
    }

    public function store(AbsenceRequest $request)
    {
        $data = $request->validated();

        $absence = $this->repository->create($data);

        return new AbsenceResource($absence);
    }

    public function update(AbsenceRequest $request, Absence $absence)
    {
        $data = $request->validated();

        $absence = $this->repository->update($absence, $data);

        return new AbsenceResource($absence);
    }

    public function destroy(Absence $absence)
    {
        $this->repository->delete($absence);

        return response()->json([
            'success' => true,
            'message' => 'absence deleted',
        ]);
    }

    public function show($id)
    {
        $absence = $this->repository->find($id);

        return new AbsenceResource($absence);
    }
}
