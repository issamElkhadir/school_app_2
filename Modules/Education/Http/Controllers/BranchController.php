<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Branch;
use Modules\Education\Http\Requests\BranchRequest;
use Modules\Education\Repositories\BranchRepository;
use Modules\Education\Transformers\BranchResource;

class BranchController extends \App\Http\Controllers\Controller
{
  protected BranchRepository $repository;

  public function __construct(BranchRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.branch.store')->only('store');
    $this->middleware('permission:education.branch.update')->only('update');
    $this->middleware('permission:education.branch.destroy')->only('destroy');
    $this->middleware('permission:education.branch.index')->only('index');
    $this->middleware('permission:education.branch.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return BranchResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(BranchRequest $request)
  {
    $data = $request->validated();

    $branch = $this->repository->create($data);

    return BranchResource::make($branch);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $branch = $this->repository->find($id);

    return BranchResource::make($branch);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(BranchRequest $request, Branch $branch)
  {
    $data = $request->validated();

    $branch = $this->repository->update($branch, $data);

    return BranchResource::make($branch);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Branch $branch)
  {
    $this->repository->delete($branch);

    return response()->json([
      'success' => true,
      'message' => 'Branch deleted.',
    ]);
  }
}
