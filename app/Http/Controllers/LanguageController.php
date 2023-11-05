<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use App\Repositories\LanguageRepository;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
  protected LanguageRepository $repository;

  public function __construct(LanguageRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:base.language.store')->only('store');
    $this->middleware('permission:base.language.update')->only('update');
    $this->middleware('permission:base.language.destroy')->only('destroy');
    $this->middleware('permission:base.language.index')->only('index');
    $this->middleware('permission:base.language.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return LanguageResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(LanguageRequest $request)
  {
    $data = $request->validated();

    $country = $this->repository->create($data);

    return LanguageResource::make($country);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $language = $this->repository->findOrFail($id);

    return LanguageResource::make($language);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(LanguageRequest $request, Language $language)
  {
    $data = $request->validated();

    $language = $this->repository->update($language, $data);

    return LanguageResource::make($language);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Language $language)
  {
    $this->repository->delete($language);

    return response()->json([
      'success' => true,
      'message' => 'Language deleted.',
    ]);
  }
}
