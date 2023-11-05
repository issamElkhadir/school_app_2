<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Education\Entities\VacationType;
use Modules\Education\Http\Requests\VacationTypeRequest;
use Modules\Education\Repositories\VacationTypeRepository;
use Modules\Education\Transformers\VacationTypeResource;

class VacationTypeController extends \App\Http\Controllers\Controller
{
  protected VacationTypeRepository $repository;

  public function __construct(VacationTypeRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.vacation-types.store')->only('store');
    $this->middleware('permission:education.vacation-types.update')->only('update');
    $this->middleware('permission:education.vacation-types.destroy')->only('destroy');
    $this->middleware('permission:education.vacation-types.index')->only('index');
    $this->middleware('permission:education.vacation-types.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return VacationTypeResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(VacationTypeRequest $request)
  {
    $data = $request->validated();

    $vacationType = $this->repository->create($data);

    return VacationTypeResource::make($vacationType);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $vacationType = $this->repository->find($id);

    return VacationTypeResource::make($vacationType);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(VacationTypeRequest $request, VacationType $vacationType)
  {
    $data = $request->validated();

    $vacationType = $this->repository->update($vacationType, $data);

    return VacationTypeResource::make($vacationType);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(VacationType $vacationType)
  {
    $this->repository->delete($vacationType);

    return response()->json([
      'success' => true,
      'message' => 'Vacations Types deleted.',
    ]);
  }
}
