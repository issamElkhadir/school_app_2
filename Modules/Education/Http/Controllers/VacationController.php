<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\Vacation;
use Modules\Education\Http\Requests\VacationRequest;
use Modules\Education\Repositories\VacationRepository;
use Modules\Education\Transformers\VacationResource;

class VacationController extends Controller
{
  protected VacationRepository $repository;

  public function __construct(VacationRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.vacation.store')->only('store');
    $this->middleware('permission:education.vacation.update')->only('update');
    $this->middleware('permission:education.vacation.destroy')->only('destroy');
    $this->middleware('permission:education.vacation.index')->only('index');
    $this->middleware('permission:education.vacation.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return VacationResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(VacationRequest $request)
  {
    $data = $request->validated();

    $vacation = $this->repository->create($data);

    return VacationResource::make($vacation);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $vacation = $this->repository->find($id);

    return VacationResource::make($vacation);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(VacationRequest $request, Vacation $vacation)
  {
    $data = $request->validated();

    $vacation = $this->repository->update($vacation, $data);

    return VacationResource::make($vacation);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Vacation $vacation)
  {
    $this->repository->delete($vacation);

    return response()->json([
      'success' => true,
      'message' => 'Vacation deleted.',
    ]);
  }
}
