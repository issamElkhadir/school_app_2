<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\AllergyType;
use Modules\Education\Http\Requests\AllergyTypeRequest;
use Modules\Education\Repositories\AllergyTypeRepository;
use Modules\Education\Transformers\AllergyTypeResource;

class AllergyTypeController extends \App\Http\Controllers\Controller
{

    protected AllergyTypeRepository $repository;

    public function __construct(AllergyTypeRepository $repository)
    {
      $this->repository = $repository;

      $this->middleware('permission:education.allergy-type.store')->only('store');
      $this->middleware('permission:education.allergy-type.update')->only('update');
      $this->middleware('permission:education.allergy-type.destroy')->only('destroy');
      $this->middleware('permission:education.allergy-type.index')->only('index');
      $this->middleware('permission:education.allergy-type.show')->only('show');
    }
    /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return AllergyTypeResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(AllergyTypeRequest $request)
  {
    $data = $request->validated();

    $allergyType = $this->repository->create($data);

    return AllergyTypeResource::make($allergyType);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $allergyType = $this->repository->find($id);

    return AllergyTypeResource::make($allergyType);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(AllergyTypeRequest $request, AllergyType $allergyType)
  {
    $data = $request->validated();

    $allergyType = $this->repository->update($allergyType, $data);

    return AllergyTypeResource::make($allergyType);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(AllergyType $allergyType)
  {
    $this->repository->delete($allergyType);

    return response()->json([
      'success' => true,
      'message' => 'Allergy Type deleted.',
    ]);
  }
}
