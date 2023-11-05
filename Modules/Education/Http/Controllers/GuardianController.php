<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Guardian;
use Modules\Education\Http\Requests\GuardianRequest;
use Modules\Education\Repositories\GuardianRepository;
use Modules\Education\Transformers\GuardianResource;

class GuardianController extends \App\Http\Controllers\Controller
{

  protected GuardianRepository $repository;

  public function __construct(GuardianRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.guardian.store')->only('store');
    $this->middleware('permission:education.guardian.update')->only('update');
    $this->middleware('permission:education.guardian.destroy')->only('destroy');
    $this->middleware('permission:education.guardian.index')->only('index');
    $this->middleware('permission:education.guardian.show')->only('show');
  }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

      return GuardianResource::collection(
        $this->paginate($request, $this->repository)
      );
    }

  /**
   * Store a newly created resource in storage.
   */
  public function store(GuardianRequest $request)
  {
    $data = $request->validated();

    $guardian = $this->repository->create($data);

    return GuardianResource::make($guardian);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $guardian = $this->repository->find($id);

    return GuardianResource::make($guardian);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(GuardianRequest $request, Guardian $guardian)
  {
    $data = $request->validated();

    $guardian = $this->repository->update($guardian, $data);

    return GuardianResource::make($guardian);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Guardian $guardian)
  {
    $this->repository->delete($guardian);

    return response()->json([
      'success' => true,
      'message' => 'Guardian deleted.',
    ]);
  }
}
