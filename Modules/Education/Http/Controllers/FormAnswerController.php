<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\FormAnswer;
use Modules\Education\Http\Requests\FormAnswerRequest;
use Modules\Education\Repositories\FormAnswerRepository;
use Modules\Education\Transformers\FormAnswerResource;

class FormAnswerController extends Controller
{
    protected FormAnswerRepository $repository ;

    public function __construct(FormAnswerRepository $repository)
    {
        $this->repository = $repository ;

        $this->middleware('permission:education.form-answer.index')->only('index');
        $this->middleware('permission:education.form-answer.show')->only('show');
        $this->middleware('permission:education.form-answer.store')->only('store');
        $this->middleware('permission:education.form-answer.update')->only('update');
        $this->middleware('permission:education.form-answer.destroy')->only('destroy');
    }

    public function index (Request $request)
    {
        return FormAnswerResource::collection(
            $this->paginate($request , $this->repository)
        );
    }

    public function store(FormAnswerRequest $request)
    {
        $data = $request->validated();

        $formAnswer = $this->repository->create($data);

        return new FormAnswerResource($formAnswer);
    }

    public function update(FormAnswerRequest $request, FormAnswer $formAnswer)
    {
        $data = $request->validated();

        $formAnswer = $this->repository->update($formAnswer, $data);

        return new FormAnswerResource($formAnswer);
    }

    public function destroy(FormAnswer $formAnswer)
    {
        $this->repository->delete($formAnswer);

        return response()->json([
        'success' => true,
        'message' => 'form answer deleted',
        ]);
    }

  public function show(int $id)
  {
    $formAnswer = $this->repository->find($id);
    return new FormAnswerResource($formAnswer);
  }
}

