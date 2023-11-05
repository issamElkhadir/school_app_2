<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\Sanction;
use Modules\Education\Http\Requests\SanctionRequest;
use Modules\Education\Repositories\SanctionRepository;
use Modules\Education\Transformers\SanctionResource;

class SanctionController extends Controller
{
  protected SanctionRepository $repository;

  public function __construct(SanctionRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.sanction.index')->only('index');
    $this->middleware('permission:education.sanction.show')->only('show');
    $this->middleware('permission:education.sanction.store')->only('store');
    $this->middleware('permission:education.sanction.update')->only('update');
    $this->middleware('permission:education.sanction.destroy')->only('destroy');
  }

  public function index(Request $request)
  {
    SanctionResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  public function store(SanctionRequest $request)
  {
    $data = $request->validated();

    $sanction = $this->repository->create($data);

    return SanctionResource::make($sanction);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $sanction = $this->repository->find($id);

    return SanctionResource::make($sanction);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(SanctionRequest $request, Sanction $sanction)
  {
    $data = $request->validated();

    $sanction = $this->repository->update($sanction, $data);

    return SanctionResource::make($sanction);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Sanction $sanction)
  {
    $this->repository->delete($sanction);

    return response()->json([
      'success' => true,
      'message' => 'Sanction deleted.',
    ]);
  }
}
