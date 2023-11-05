<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Category;
use Modules\Education\Http\Requests\CategoryRequest;
use Modules\Education\Repositories\CategoryRepository;
use Modules\Education\Transformers\CategoryResource;

class CategoryController extends \App\Http\Controllers\Controller
{
  protected CategoryRepository $repository;

  public function __construct(CategoryRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.category.store')->only('store');
    $this->middleware('permission:education.category.update')->only('update');
    $this->middleware('permission:education.category.destroy')->only('destroy');
    $this->middleware('permission:education.category.index')->only('index');
    $this->middleware('permission:education.category.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return CategoryResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CategoryRequest $request)
  {
    $data = $request->validated();

    $category = $this->repository->create($data);

    return CategoryResource::make($category);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $category = $this->repository->find($id);

    return CategoryResource::make($category);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CategoryRequest $request, Category $category)
  {
    $data = $request->validated();

    $category = $this->repository->update($category, $data);

    return CategoryResource::make($category);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Category $category)
  {
    $this->repository->delete($category);

    return response()->json([
      'success' => true,
      'message' => 'Category deleted.',
    ]);
  }
}
