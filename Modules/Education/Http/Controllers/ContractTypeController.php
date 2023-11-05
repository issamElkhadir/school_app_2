<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Education\Entities\ContractType;
use Modules\Education\Http\Requests\ContractTypeRequest;
use Modules\Education\Repositories\ContractTypeRepository;
use Modules\Education\Transformers\ContractTypeResource;

class ContractTypeController extends Controller
{
    protected ContractTypeRepository $repository ;

    public function __construct(ContractTypeRepository $repository){
        $this->repository = $repository;

        $this->middleware('permission:education.contract-type.index')->only('index');
        $this->middleware('permission:education.contract-type.show')->only('show');
        $this->middleware('permission:education.contract-type.store')->only('store');
        $this->middleware('permission:education.contract-type.update')->only('update');
        $this->middleware('permission:education.contract-type.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        return ContractTypeResource::collection(
            $this->paginate($request, $this->repository)
        );
    }

    public function store(ContractTypeRequest $request)
    {
        $data = $request->validated();

        $contractType = $this->repository->create($data);

        return new ContractTypeResource($contractType);
    }

    public function update(ContractTypeRequest $request , ContractType $contractType)
    {
        $data = $request->validated();

        $this->repository->update($contractType, $data);

        return new ContractTypeResource($contractType);
    }

    public function destroy(ContractType $contractType)
    {
        $this->repository->delete($contractType);

        return response()->json([
            'success' => true,
            'message' => 'contact type deleted successfully'
        ]);
    }

    public function show ($id)
    {
        $contractType = $this->repository->find($id);

        return new ContractTypeResource($contractType);
    }
}
