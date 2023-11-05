<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Http\Requests\EventCategoryRequest;
use Modules\Education\Repositories\EventCategoryRepository;
use Modules\Education\Transformers\EventCategoryResource;

class EventCategoryController extends Controller
{
  protected EventCategoryRepository $repository;

  public function __construct(EventCategoryRepository $repository)
  {
    $this->repository = $repository;
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $models = $this->paginate(request(), $this->repository);

    return EventCategoryResource::collection($models);
  }


  /**
   * Store a newly created resource in storage.
   * @param Request $request
   */
  public function store(EventCategoryRequest $request)
  {
    $attributes = $request->validated();

    $model = $this->repository->create($attributes);

    return EventCategoryResource::make($model);
  }

  /**
   * Show the specified resource.
   * @param int $id
   */
  public function show($id)
  {
    $model = $this->repository->findOrFail($id);

    return EventCategoryResource::make($model);
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   */
  public function update(EventCategoryRequest $request, $id)
  {
    $attributes = $request->validated();

    $model = $this->repository->update($id, $attributes);

    return EventCategoryResource::make($model);
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   */
  public function destroy($id)
  {
    $this->repository->delete($id);

    return response()->noContent();
  }
}
