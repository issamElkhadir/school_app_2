<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Pack;
use Modules\Education\Http\Requests\PackRequest;
use Modules\Education\Repositories\PackRepository;
use Modules\Education\Transformers\PackResource;

class PackController extends \App\Http\Controllers\Controller
{
  protected PackRepository $repository;

  public function __construct(PackRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.pack.store')->only('store');
    $this->middleware('permission:education.pack.update')->only('update');
    $this->middleware('permission:education.pack.destroy')->only('destroy');
    $this->middleware('permission:education.pack.index')->only('index');
    $this->middleware('permission:education.pack.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return PackResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(PackRequest $request)
  {
    $data = $request->validated();

    $pack = $this->repository->create($data);

    return PackResource::make($pack);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $pack = $this->repository->find($id);

    return PackResource::make($pack);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(PackRequest $request, Pack $pack)
  {
    $data = $request->validated();

    $pack = $this->repository->update($pack, $data);

    return PackResource::make($pack);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Pack $pack)
  {
    $this->repository->delete($pack);

    return response()->json([
      'success' => true,
      'message' => 'Pack deleted.',
    ]);
  }
}
