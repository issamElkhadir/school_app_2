<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslationRequest;
use App\Http\Resources\TranslationResource;
use App\Models\Translation;
use App\Repositories\TranslationRepository;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
  protected TranslationRepository $repository;

  public function __construct(TranslationRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:base.translation.store')->only('store');
    $this->middleware('permission:base.translation.update')->only('update');
    $this->middleware('permission:base.translation.destroy')->only('destroy');
    $this->middleware('permission:base.translation.index')->only('index');
    $this->middleware('permission:base.translation.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return TranslationResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(TranslationRequest $request)
  {
    $data = $request->validated();

    $translation = $this->repository->create($data);

    return TranslationResource::make($translation);
  }

  /**
   * Display the specified resource.
   */
  public function show(int $id)
  {
    $translation = $this->repository->find($id);

    return TranslationResource::make($translation);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(TranslationRequest $request, Translation $translation)
  {
    $data = $request->validated();

    $translation = $this->repository->update($translation, $data);

    return TranslationResource::make($translation);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Translation $translation)
  {
    $this->repository->delete($translation);

    return response()->noContent();
  }

  public function getTranslations(Request $request)
  {
    $module = $request->module ?? 'base';
    $locale = $request->locale ?? 'en_US';
    $cacheSignature = $request->signature ?? null;

    $lastModified = $this->repository->getLastModified($request->module);

    if ($cacheSignature && $cacheSignature === md5($lastModified)) {
      return response()->json([
        'cache' => true,
      ]);
    }

    $translations = $this->repository->getTranslations($module, $locale);

    return response()->json([
      'cache' => false,
      'translations' => $translations,
      'signature' => md5($lastModified),
    ]);
  }
}
