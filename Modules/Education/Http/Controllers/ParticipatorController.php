<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\Participator;
use Modules\Education\Http\Requests\ParticipatorRequest;
use Modules\Education\Repositories\ParticipatorRepository;
use Modules\Education\Transformers\ParticipatorResource;

class ParticipatorController extends Controller
{
    protected ParticipatorRepository $repository ;

    public function __construct(ParticipatorRepository $repository)
    {
        $this->repository = $repository ;

        $this->middleware('permission:education.participator.index')->only('index');
        $this->middleware('permission:education.participator.show')->only('show');
        $this->middleware('permission:education.participator.store')->only('store');
        $this->middleware('permission:education.participator.update')->only('update');
        $this->middleware('permission:education.participator.destroy')->only('destroy');
    }

    public function index (Request $request)
    {
        return ParticipatorResource::collection(
            $this->paginate($request , $this->repository)
        );
    }

    public function store(ParticipatorRequest $request)
    {
        $data = $request->validated();

        $participator = $this->repository->create($data);

        return new ParticipatorResource($participator);
    }

    public function update(ParticipatorRequest $request, Participator $participator)
    {
        $data = $request->validated();

        $participator = $this->repository->update($participator, $data);

        return new ParticipatorResource($participator);
    }

    public function destroy(Participator $participator)
    {
        $this->repository->delete($participator);

        return response()->json([
        'success' => true,
        'message' => 'participator deleted',
        ]);
    }

  public function show(int $id)
  {
    $participator = $this->repository->find($id);

    return new ParticipatorResource($participator);
  }
}
