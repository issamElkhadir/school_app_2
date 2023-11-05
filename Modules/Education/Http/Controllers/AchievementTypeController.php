<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\AchievementType;
use Modules\Education\Http\Requests\AchievementTypeRequest;
use Modules\Education\Repositories\AchievementTypeRepository;
use Modules\Education\Transformers\AchievementTypeResource;

class AchievementTypeController extends Controller
{
  protected AchievementTypeRepository $repository;

  public function __construct(AchievementTypeRepository $repository)
  {
    $this->repository = $repository;
    $this->middleware('permission:education.achievement-type.index')->only('index');
    $this->middleware('permission:education.achievement-type.show')->only('show');
    $this->middleware('permission:education.achievement-type.store')->only('store');
    $this->middleware('permission:education.achievement-type.update')->only('update');
    $this->middleware('permission:education.achievement-type.destroy')->only('destroy');
  }

  public function index(Request $request)
  {
    return AchievementTypeResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  public function store(AchievementTypeRequest $request)
  {
    $data = $request->validated();

    $achievementType = $this->repository->create($data);

    return new AchievementTypeResource($achievementType);
  }

  public function show($id)
  {

    $achievementType = $this->repository->find($id);

    return new AchievementTypeResource($achievementType);
  }

  public function update(AchievementTypeRequest $request, AchievementType $achievementType)
  {
    $data = $request->validated();

    $achievementType = $this->repository->update($achievementType, $data);

    return new AchievementTypeResource($achievementType);

  }

  public function destroy(AchievementType $achievementType)
  {
    $this->repository->delete($achievementType);

    return response()->json(
      [
        'success' => true,
        'message' => 'Achievement Type Deleted'

      ]
    );
  }
}
