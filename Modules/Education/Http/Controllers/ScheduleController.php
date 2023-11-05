<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\Schedule;
use Modules\Education\Http\Requests\ScheduleRequest;
use Modules\Education\Repositories\ScheduleRepository;
use Modules\Education\Transformers\ScheduleResource;

class ScheduleController extends Controller
{
  protected ScheduleRepository $repository;


  public function __construct(ScheduleRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:education.schedule.index')->only('index');
    $this->middleware('permission:education.schedule.store')->only('store');
    $this->middleware('permission:education.schedule.update')->only('update');
    $this->middleware('permission:education.schedule.destroy')->only('destroy');
    $this->middleware('permission:education.schedule.show')->only('show');

  }

  public function index(Request $request){
    return ScheduleResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  public function store(ScheduleRequest $request)
  {
    $data = $request->validated();

    $schedule = $this->repository->create($data);

    return new ScheduleResource($schedule);

  }

  public function update(ScheduleRequest $request, Schedule $schedule)
  {
    $data = $request->validated();

    $schedule = $this->repository->update($schedule, $data);

    return new ScheduleResource($schedule);

  }

  public function destroy(Schedule $schedule)
  {
    $this->repository->delete($schedule);

    return response()->json([
      'success' => true,
      'message' => 'Schedule deleted.',
    ]);

  }

  public function show($id)
  {
    $schedule = $this->repository->find($id);

    return ScheduleResource::make($schedule);
  }


}
