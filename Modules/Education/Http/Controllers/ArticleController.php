<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Education\Entities\Article;
use Modules\Education\Http\Requests\ArticleRequest;
use Modules\Education\Repositories\ArticleRepository;
use Modules\Education\Transformers\ArticleResource;

class ArticleController extends \App\Http\Controllers\Controller
{
  protected ArticleRepository $repository;

  public function __construct(ArticleRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.article.store')->only('store');
    $this->middleware('permission:education.article.update')->only('update');
    $this->middleware('permission:education.article.destroy')->only('destroy');
    $this->middleware('permission:education.article.index')->only('index');
    $this->middleware('permission:education.article.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    return ArticleResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ArticleRequest $request)
  {
    $data = $request->validated();

    $article = $this->repository->create($data);

    return ArticleResource::make($article);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $article = $this->repository->find($id);

    return ArticleResource::make($article);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ArticleRequest $request, Article $article)
  {
    $data = $request->validated();

    $article = $this->repository->update($article, $data);

    return ArticleResource::make($article);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Article $article)
  {
    $this->repository->delete($article);

    return response()->json([
      'success' => true,
      'message' => 'Article deleted.',
    ]);
  }
}
