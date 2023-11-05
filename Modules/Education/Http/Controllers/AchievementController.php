<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\Achievement;
use Modules\Education\Http\Requests\AchievementRequest;
use Modules\Education\Repositories\AchievementRepository;
use Modules\Education\Transformers\AchievementResource;

class AchievementController extends Controller
{
  protected AchievementRepository $repository;
  public function __construct(AchievementRepository $repository)
  {
    $this->repository = $repository;
    $this->middleware('permission:education.achievement.index')->only('index');
    $this->middleware('permission:education.achievement.show')->only('show');
    $this->middleware('permission:education.achievement.store')->only('store');
    $this->middleware('permission:education.achievement.update')->only('update');
    $this->middleware('permission:education.achievement.destroy')->only('destroy');
  }

  public function index(Request $request)
  {
    return AchievementResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  public function store(AchievementRequest $request)
  {
    $data = $request->validated();

    $achievement = $this->repository->create($data);

    return new AchievementResource($achievement);
  }

  public function show($id)
  {

    $achievement = $this->repository->find($id);

    return new AchievementResource($achievement);
  }

  public function update(AchievementRequest $request, Achievement $achievement)
  {
    $data = $request->validated();

    $achievement = $this->repository->update($achievement, $data);

    return new AchievementResource($achievement);

  }

  public function destroy(Achievement $achievement)
  {
    $this->repository->delete($achievement);

    return response()->json(
      [
        'success' => true,
        'message' => 'Achievement Deleted'

      ]
    );
  }
}
