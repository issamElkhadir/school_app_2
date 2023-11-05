<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Allergy;
use Modules\Education\Http\Requests\AllergyRequest;
use Modules\Education\Repositories\AllergyRepository;
use Modules\Education\Transformers\AllergyResource;

class AllergyController extends \App\Http\Controllers\Controller
{
  protected AllergyRepository $repository;

  public function __construct(AllergyRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.allergy.store')->only('store');
    $this->middleware('permission:education.allergy.update')->only('update');
    $this->middleware('permission:education.allergy.destroy')->only('destroy');
    $this->middleware('permission:education.allergy.index')->only('index');
    $this->middleware('permission:education.allergy.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return AllergyResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(AllergyRequest $request)
  {
    $data = $request->validated();

    $allergy = $this->repository->create($data);

    return AllergyResource::make($allergy);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $allergy = $this->repository->find($id);

    return AllergyResource::make($allergy);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(AllergyRequest $request, Allergy $allergy)
  {
    $data = $request->validated();

    $allergy = $this->repository->update($allergy, $data);

    return AllergyResource::make($allergy);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Allergy $allergy)
  {
    $this->repository->delete($allergy);

    return response()->json([
      'success' => true,
      'message' => 'Allergy deleted.',
    ]);
  }
}
