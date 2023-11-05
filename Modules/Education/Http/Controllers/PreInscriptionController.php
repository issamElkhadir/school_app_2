<?php

namespace Modules\Education\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Education\Entities\Participator;
use Modules\Education\Entities\PreInscription;
use Modules\Education\Http\Requests\PreInscriptionRequest;
use Modules\Education\Repositories\PreInscriptionRepository;
use Modules\Education\Transformers\PreInscriptionResource;

class PreInscriptionController extends Controller
{
    protected PreInscriptionRepository $repository;

    public function __construct(PreInscriptionRepository $repository)
    {
        $this->repository = $repository;

        $this->middleware('permission:education.pre-inscription.index')->only('index');
        $this->middleware('permission:education.pre-inscription.show')->only('show');
        $this->middleware('permission:education.pre-inscription.store')->only('store');
        $this->middleware('permission:education.pre-inscription.update')->only('update');
        $this->middleware('permission:education.pre-inscription.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        return PreInscriptionResource::collection(
            $this->paginate($request, $this->repository)
        );
    }

    public function store(PreInscriptionRequest $request)
    {
        $data = $request->validated();

        $preInscription = $this->repository->create($data);

        return new PreInscriptionResource($preInscription);
    }

    public function update(PreInscriptionRequest $request, PreInscription $preInscription)
    {
        $data = $request->validated();

        $preInscription = $this->repository->update($preInscription, $data);

        return new PreInscriptionResource($preInscription);
    }

    public function destroy(PreInscription $preInscription)
    {
        $this->repository->delete($preInscription);

        return response()->json([
            'success' => true,
            'message' => 'pre-inscription deleted',
        ]);
    }

    public function show(int $id)
    {
        $preInscription = $this->repository->find($id);

        return new PreInscriptionResource($preInscription);
    }

    public function getPreInscriptionBySlug(string $slug)
    {
        return $this->repository->getPreInscriptionBySlug($slug);
    }

    public function checkEmail (Request $request){
        $validatedData = $request->validate([
            'email' => 'required|string',
            'form_id' => 'required|min:0',
        ]);
        return $this->repository->checkEmailExistence($validatedData);
    }
    public function checkEmailPassword (Request $request){
        $validatedData = $request->validate([
            'email' => 'required|string',
            'form_id' => 'required|min:0',
            'password' => 'required|min:0'
        ]);
        return $this->repository->checkEmailPassword($validatedData);
    }

    public function submitForm(Request $request){
        $validatedData = $request->validate([
            'form_id' => 'required|exists:forms,id',
            'email' => 'required|string|email',
            'first_name' => 'required|string|min:0',
            'last_name' => 'required|string|min:0',
            'password' => 'required|min:0',
            'answers' => 'required|array',
            'answers.sections' => 'required|array',
            'answers.sections.*.id' => 'required|min:0',
            'answers.sections.*.questions' => 'required|array',
            'answers.sections.*.questions.*.id' => 'required|min:0',
            'answers.sections.*.questions.*.answer' => 'nullable',
        ]);
        return $this->repository->submitForm($validatedData);
    }

    public function updateForm (Request $request){
        $validatedData = $request->validate([
            'participator_id' => 'required|exists:participators,id',
            'form_id' => 'required|exists:forms,id',
            'answers' => 'required|array',
            'answers.sections' => 'required|array',
            'answers.sections.*.id' => 'required|min:0',
            'answers.sections.*.questions' => 'required|array',
            'answers.sections.*.questions.*.id' => 'required|min:0',
            'answers.sections.*.questions.*.answer' => 'nullable',
        ]);
        return $this->repository->updateForm($validatedData);
    }
}
