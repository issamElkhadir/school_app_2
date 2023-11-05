<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Education\Entities\FormQuestion;
use Modules\Education\Http\Requests\FormQuestionRequest;
use Modules\Education\Repositories\FormQuestionRepository;
use Modules\Education\Transformers\FormQuestionResource;

class FormQuestionController extends Controller
{
    protected FormQuestionRepository $repository ;

    public function __construct(FormQuestionRepository $repository){
        $this->repository = $repository;

        $this->middleware('permission:education.form-question.index')->only('index');
        $this->middleware('permission:education.form-question.store')->only('store');
        $this->middleware('permission:education.form-question.update')->only('update');
        $this->middleware('permission:education.form-question.destory')->only('destory');
        $this->middleware('permission:education.form-question.show')->only('show');
    }

    public function index(Request $request)
    {
        return FormQuestionResource::collection(
            $this->paginate($request, $this->repository)
        );
    }

    public function store(FormQuestionRequest  $request) {
        $data = $request->validated();
        $formQuestion = $this->repository->create($data);
        return FormQuestionResource::make($formQuestion);
    }
    public function update(FormQuestionRequest $request , FormQuestion $formQuestion){
        $data = $request->validated();
        $formQuestion = $this->repository->update($formQuestion , $data);
        return FormQuestionResource::make($formQuestion);
    }
    public function destroy(FormQuestion $formQuestion){
        $this->repository->delete($formQuestion);
        return response()->json([
            'success' => true,
            'message' => 'question is deleted',
        ]);
    }
    public function show(int $id){
        $formQuestion = $this->repository->find($id);
        return FormQuestionResource::make($formQuestion); 
    }
}
