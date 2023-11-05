<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\SanctionType;
use Modules\Education\Http\Requests\SanctionTypeRequest;
use Modules\Education\Repositories\SanctionTypeRepository;
use Modules\Education\Transformers\SanctionTypeResource;

class SanctionTypeController extends Controller
{

  protected SanctionTypeRepository $repository;
  public function __construct(SanctionTypeRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.sanction-type.index')->only('index');
    $this->middleware('permission:education.sanction-type.show')->only('show');
    $this->middleware('permission:education.sanction-type.store')->only('store');
    $this->middleware('permission:education.sanction-type.update')->only('update');
    $this->middleware('permission:education.sanction-type.destroy')->only('destroy');
  }

  public function index(Request $request)
  {
    SanctionTypeResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  public function store(SanctionTypeRequest $request)
  {
    $data = $request->validated();

    $sanctionType = $this->repository->create($data);

    return SanctionTypeResource::make($sanctionType);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $sanctionType = $this->repository->find($id);

    return SanctionTypeResource::make($sanctionType);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(SanctionTypeRequest $request, SanctionType $sanctionType)
  {
    $data = $request->validated();

    $sanctionType = $this->repository->update($sanctionType, $data);

    return SanctionTypeResource::make($sanctionType);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(SanctionType $sanctionType)
  {
    $this->repository->delete($sanctionType);

    return response()->json([
      'success' => true,
      'message' => 'Sanction Type deleted.',
    ]);
  }
}
