<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Education\Http\Requests\DiseaseRequest;
use Modules\Education\Repositories\DiseaseRepository;
use Modules\Education\Transformers\DiseaseResource;

class DiseaseController extends Controller
{
  protected DiseaseRepository $repository;

  public function __construct(DiseaseRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.disease.store')->only('store');
    $this->middleware('permission:education.disease.update')->only('update');
    $this->middleware('permission:education.disease.index')->only('index');
    $this->middleware('permission:education.disease.destroy')->only('destroy');
    $this->middleware('permission:education.disease.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $data = $this->paginate($request, $this->repository);

    return DiseaseResource::collection($data);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(DiseaseRequest $request)
  {
    $data = $request->validated();

    $disease = $this->repository->create($data);

    return DiseaseResource::make($disease);
  }

  /**
   * Show the specified resource.
   * @param int $id
   */
  public function show($id)
  {
    $disease = $this->repository->findOrFail($id);

    return DiseaseResource::make($disease);
  }

  /**
   * Update the specified resource in storage.
   * @param DiseaseRequest $request
   * @param int $id
   */
  public function update(DiseaseRequest $request, $id)
  {
    $data = $request->validated();

    $disease = $this->repository->update($id, $data);

    return DiseaseResource::make($disease);
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy($id)
  {
    $this->repository->delete($id);

    return response()->noContent();
  }
}
