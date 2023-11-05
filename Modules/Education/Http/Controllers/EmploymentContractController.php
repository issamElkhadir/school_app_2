<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Education\Entities\EmploymentContract;
use Modules\Education\Http\Requests\EmploymentContractRequest;
use Modules\Education\Repositories\EmploymentContractRepository;
use Modules\Education\Transformers\EmploymentContractResource;

class EmploymentContractController extends Controller
{
    protected EmploymentContractRepository $repository;

    public function __construct(EmploymentContractRepository $repository)
    {
        $this->repository = $repository;

        $this->middleware('permission:education.employment-contract.index')->only('index');
        $this->middleware('permission:education.employment-contract.show')->only('show');
        $this->middleware('permission:education.employment-contract.store')->only('store');
        $this->middleware('permission:education.employment-contract.update')->only('update');
        $this->middleware('permission:education.employment-contract.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        return EmploymentContractResource::collection(
            $this->paginate($request, $this->repository)
        );
    }

    public function store(EmploymentContractRequest $request)
    {
        $data = $request->validated();

        $employmentContract = $this->repository->create($data);

        return new EmploymentContractResource($employmentContract);
    }

    public function update(EmploymentContractRequest $request, EmploymentContract $employmentContract)
    {
        $data = $request->validated();

        $employmentContract = $this->repository->update($employmentContract, $data);

        return new EmploymentContractResource($employmentContract);
    }

    public function destroy(EmploymentContract $employmentContract)
    {
        $this->repository->delete($employmentContract);

        return response()->json([
            'success' => true,
            'message' => 'Employment contract deleted',
        ]);
    }

    public function show($id)
    {
        $employmentContract = $this->repository->find($id);

        return new EmploymentContractResource($employmentContract);
    }
}
