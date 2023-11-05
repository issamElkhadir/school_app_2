<?php

namespace Modules\Education\Repositories;

use App\Filters\DateAfterFilter;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Modules\Education\Entities\FormAnswer;
use Modules\Education\Entities\Participator;
use Modules\Education\Entities\PreInscription;
use Modules\Education\Transformers\PreInscriptionResource;
use Spatie\QueryBuilder\AllowedFilter;

class PreInscriptionRepository extends BaseRepository
{
  protected ParticipatorRepository $participatorRepository;
  protected FormAnswerRepository $formAnswerRepository;

  public function __construct(ParticipatorRepository $participatorRepository, FormAnswerRepository $formAnswerRepository)
  {
    $this->participatorRepository = $participatorRepository;
    $this->formAnswerRepository = $formAnswerRepository;
  }

  public function model()
  {
    return PreInscription::class;
  }

  private function prepareAttributes(array $attributes): array
  {
    $attributes['school_id'] = $attributes['school']['id'];
    unset($attributes['school']);
    $attributes['form_id'] = $attributes['form']['id'];
    unset($attributes['form']);
    $attributes['level_id'] = $attributes['level']['id'];
    unset($attributes['level']);
    return $attributes;
  }

  public function create(array $attributes)
  {
    $attributes = $this->prepareAttributes($attributes);
    $attributes['slug'] = $attributes['title'] . '-' . Carbon::now()->timestamp;
    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes = $this->prepareAttributes($attributes);
    return parent::update($model, $attributes);
  }

  public function getPreInscriptionBySlug(string $slug)
  {
    $id = PreInscription::where('slug', $slug)
      ->value('id');
    if ($id) {
      $preInscription = $this->find($id);
      if ($preInscription) {
        $currentDateTime = Carbon::now();
        $startDateTime = $preInscription->start_date_time;
        $endDateTime = $preInscription->end_date_time;
        $status = $preInscription->status;

        if ($currentDateTime < $startDateTime) {
          return response()->json(['success' => false, 'message' => 'The pre-inscription period has not started yet.'], 400);
        } elseif ($currentDateTime > $endDateTime) {
          return response()->json(['success' => false, 'message' => 'The pre-inscription period has ended.'], 400);
        } elseif (!$status) {
          return response()->json(['success' => false, 'message' => 'The pre-inscription is not currently active.'], 400);
        } else {
          $preInscription->load('form.sections.questions');
          return new PreInscriptionResource($preInscription);
        }
      } else {
        return response()->json(['success' => false, 'message' => 'Pre-inscription not found.'], 404);
      }
    } else {
      return response()->json(['success' => false, 'message' => 'Invalid slug.'], 400);
    }
  }

  public function checkEmailExistence(array $data)
  {
    $isEmailUsed = Participator::where('email', $data['email'])
      ->where('form_id', $data['form_id'])
      ->exists();
    if ($isEmailUsed) {
      return response()->json(['success' => false, 'message' => 'Email is already associated with this pre-inscription'], 422);
    } else {
      return response()->json(['success' => true, 'message' => ''], 200);
    }
  }

  public function checkEmailPassword(array $data)
{
    $participator = Participator::where('email', $data['email'])
        ->where('form_id', $data['form_id'])
        ->first();
    
    if (!$participator) {
        return response()->json(['success' => false, 'message' => 'Email is not associated with this pre-inscription'], 422);
    }
    
    if ($data['password'] !== $participator->password) {
        return response()->json(['success' => false, 'message' => 'Incorrect password'], 422);
    }

    $formAnswers = FormAnswer::where('participator_id', $participator->id)
        ->with(['section:id', 'question:id,is_required,type'])
        ->get();

    $answers = [
        'sections' => []
    ];

    foreach ($formAnswers as $formAnswer) {
        $sectionId = $formAnswer->section->id;

        if (!isset($answers['sections'][$sectionId])) {
            $answers['sections'][$sectionId] = [
                'id' => $sectionId,
                'questions' => [],
            ];
        }

        $answers['sections'][$sectionId]['questions'][] = [
            'id' => $formAnswer->question->id,
            'is_required' => $formAnswer->question->is_required,
            'type' => $formAnswer->question->type,
            'answer' => $formAnswer->answer,
        ];
    }
    // remove $answers['sections'][$sectionId] from every section
    $answers['sections'] = array_values($answers['sections']);
    return response()->json(['success' => true, 'data' => ['answers' => $answers ,'participator_id' => $participator->id]], 200);
}


  public function submitForm(array $data)
  {
    try {
      \DB::beginTransaction();
      $participatorData['email'] = $data['email'];
      $participatorData['password'] = $data['password'];
      $participatorData['first_name'] = $data['first_name'];
      $participatorData['last_name'] = $data['last_name'];
      $participatorData['form']['id'] = $data['form_id'];
      $participator = $this->participatorRepository->create($participatorData);

      $answers = $data['answers'];

      if (count($answers['sections']) > 0) {
        foreach ($answers['sections'] as $section) {
          if (count($section['questions']) > 0) {
            foreach ($section['questions'] as $question) {
              $formAnswerData['participator']['id'] = $participator['id'];
              $formAnswerData['question']['id'] = $question['id'];
              $formAnswerData['section']['id'] = $section['id'];
              $formAnswerData['answer'] = $question['answer'] ?? '';
              $this->formAnswerRepository->create($formAnswerData);
            }
          }
        }
      }
      \DB::commit();
      return $participator;
    } catch (\Throwable $e) {
      \DB::rollBack();
      throw $e;
    }
  }

  public function updateForm (array $data){
    try {
      \DB::beginTransaction();
      $participator = Participator::where('id' , $data['participator_id'])
                                    ->where('form_id' , $data['form_id'])
                                    ->first();
      if(!$participator){
        return response()->json(['success'=>false , 'message' => 'participator not found']);
      }
      if(count($data['answers']['sections']) > 0){
        foreach($data['answers']['sections'] as $section){
          if(count($section['questions']) > 0){
            foreach($section['questions'] as $question){
              $formAnswerData = [
                'participator' => ['id' => $participator->id],
                'question' => ['id' => $question['id']],
                'section' => ['id' => $section['id']],
                'answer' => $question['answer'] ?? '',
              ];

              $existingFormAnswer = FormAnswer::where('participator_id' , $participator->id)
                                              ->where('question_id' , $question['id'])
                                              ->where('section_id' , $section['id'])
                                              ->first();
              if($existingFormAnswer){
                $this->formAnswerRepository->updateModel($existingFormAnswer->id , $formAnswerData);
              }else {
                $this->formAnswerRepository->create($formAnswerData);
              }
            }
          }
        }
      }
      \DB::commit();
      return response()->json(['success' => true , 'message' => 'Form has been updated successfully']);
    } catch (\Throwable $e) {
      \DB::rollBack();
      throw $e;
    }
  }
  public function allowedIncludes(): array
  {
    return [
      'school:id,name',
      'level:id,name',
      'form',
      'form.sections',
      'form.sections.questions'
    ];
  }

  public function defaultIncludes(): array
  {
    return [
      'school:id,name',
      'level:id,name',
      'form',
      'form.sections',
      'form.sections.questions'
    ];
  }

  public function allowedSorts(): array
  {
    return [
      'id',
      'title',
      'slug',
      'description',
      'status',
      'start_date_time',
      'end_date_time',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('title'),
      AllowedFilter::partial('slug'),
      AllowedFilter::partial('description'),
      AllowedFilter::partial('status'),
      AllowedFilter::custom('start_date_time', new DateAfterFilter()),
      AllowedFilter::custom('end_date_time', new DateAfterFilter()),
    ];
  }

  public function allowedFields(): array
  {
    return [
      'id',
      'title',
      'slug',
      'description',
      'status',
      'start_date_time',
      'end_date_time',
      'school',
      'school_id',
      'school.id',
      'school.name',
      'form',
      'form.id',
      'form.name',
      'form_id',
      'level',
      'level.id',
      'level.name',
      'level_id'
    ];
  }

  public function searchFields(): array
  {
    return [
      'id',
      'title',
      'slug',
      'description',
      'status',
      'start_date_time',
      'end_date_time',
    ];
  }
}
