<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\PackArticle;
use Modules\Education\Http\Requests\PackArticleRequest;
use Modules\Education\Repositories\PackArticleRepository;
use Modules\Education\Transformers\PackArticleResource;

class PackArticleController extends \App\Http\Controllers\Controller
{
  protected PackArticleRepository $repository;

  public function __construct(PackArticleRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.pack-article.store')->only('store');
    $this->middleware('permission:education.pack-article.update')->only('update');
    $this->middleware('permission:education.pack-article.destroy')->only('destroy');
    $this->middleware('permission:education.pack-article.index')->only('index');
    $this->middleware('permission:education.pack-article.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return PackArticleResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(PackArticleRequest $request)
  {
    $data = $request->validated();

    $pack = $this->repository->create($data);

    return PackArticleResource::make($pack);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $pack = $this->repository->find($id);

    return PackArticleResource::make($pack);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(PackArticleRequest $request, PackArticle $pack)
  {
    $data = $request->validated();

    $pack = $this->repository->update($pack, $data);

    return PackArticleResource::make($pack);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(PackArticle $pack)
  {
    $this->repository->delete($pack);

    return response()->json([
      'success' => true,
      'message' => 'Pack Article deleted.',
    ]);
  }
}
