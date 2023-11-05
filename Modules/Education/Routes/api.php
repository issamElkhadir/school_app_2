<?php

use Modules\Education\Entities\EmploymentContract;
use Modules\Education\Http\Controllers\AbsenceController;
use Modules\Education\Http\Controllers\AbsenceTypeController;
use Modules\Education\Http\Controllers\AcademicYearController;
use Modules\Education\Http\Controllers\AllergyController;
use Modules\Education\Http\Controllers\AllergyTypeController;
use Modules\Education\Http\Controllers\AppointmentRequestController;
use Modules\Education\Http\Controllers\AchievementController;
use Modules\Education\Http\Controllers\AchievementTypeController;
use Modules\Education\Http\Controllers\ArticleController;
use Modules\Education\Http\Controllers\BranchController;
use Modules\Education\Http\Controllers\CategoryController;
use Modules\Education\Http\Controllers\ClassController;
use Modules\Education\Http\Controllers\ClassroomController;
use Modules\Education\Http\Controllers\ClassroomTypeController;
use Modules\Education\Http\Controllers\ContractTypeController;
use Modules\Education\Http\Controllers\CycleController;
use Modules\Education\Http\Controllers\DiseaseController;
use Modules\Education\Http\Controllers\EventCategoryController;
use Modules\Education\Http\Controllers\DoctorController;
use Modules\Education\Http\Controllers\EmploymentContractController;
use Modules\Education\Http\Controllers\FormAnswerController;
use Modules\Education\Http\Controllers\FormController;
use Modules\Education\Http\Controllers\FormSectionController;
use Modules\Education\Http\Controllers\GuardianController;
use Modules\Education\Http\Controllers\LevelController;
use Modules\Education\Http\Controllers\MedicalFormController;
use Modules\Education\Http\Controllers\PackController;
use Modules\Education\Http\Controllers\ParticipatorController;
use Modules\Education\Http\Controllers\PaymentBillController;
use Modules\Education\Http\Controllers\PaymentBillLineController;
use Modules\Education\Http\Controllers\PaymentController;
use Modules\Education\Http\Controllers\PaymentScheduleController;
use Modules\Education\Http\Controllers\PeriodController;
use Modules\Education\Http\Controllers\PreInscriptionController;
use Modules\Education\Http\Controllers\ScheduleController;
use Modules\Education\Http\Controllers\SessionController;
use Modules\Education\Http\Controllers\SkillController;
use Modules\Education\Http\Controllers\StaffAuthorizationRequestController;
use Modules\Education\Http\Controllers\SanctionController;
use Modules\Education\Http\Controllers\SanctionTypeController;
use Modules\Education\Http\Controllers\StaffController;
use Modules\Education\Http\Controllers\StudentAbsenceAuthorizationRequestController;
use Modules\Education\Http\Controllers\StudentAuthorizationRequestController;
use Modules\Education\Http\Controllers\StudentController;
use Modules\Education\Http\Controllers\SubjectController;
use Modules\Education\Http\Controllers\SubjectSequenceController;
use Modules\Education\Http\Controllers\SubscriptionController;
use Modules\Education\Http\Controllers\UnityController;
use Modules\Education\Http\Controllers\VacationController;
use Modules\Education\Http\Controllers\VacationTypeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('api.education.')
  ->middleware('auth:api')
  ->prefix('v1/education')
  ->group(function () {

    Route::apiResources([
      'guardians' => GuardianController::class,
      'students' => StudentController::class,
      'staff' => StaffController::class,
      'classroom-types' => ClassroomTypeController::class,
      'classrooms' => ClassroomController::class,
      'cycles' => CycleController::class,
      'branches' => BranchController::class,
      'levels' => LevelController::class,
      'unities' => UnityController::class,
      'periods' => PeriodController::class,
      'subjects' => SubjectController::class,
      'classes' => ClassController::class,
      'subject-sequences' => SubjectSequenceController::class,
      'academic-years' => AcademicYearController::class,
      'categories' => CategoryController::class,
      'articles' => ArticleController::class,
      'packs' => PackController::class,
      'subscriptions' => SubscriptionController::class,
      'payments' => PaymentController::class,
      'payment-bills' => PaymentBillController::class,
      'payment-bill-lines' => PaymentBillLineController::class,
      //      'payment-schedules' => PaymentScheduleController::class,
      'schedules' => ScheduleController::class,
      'sessions' => SessionController::class,
      'skills' => SkillController::class,

      'absence-types' => AbsenceTypeController::class,
      'event-categories' => EventCategoryController::class,
      'diseases' => DiseaseController::class,

      'allergy-types' => AllergyTypeController::class,
      'allergies' => AllergyController::class,

      'staff-authorization-requests' => StaffAuthorizationRequestController::class,
      'student-authorization-requests' => StudentAuthorizationRequestController::class,
      'student-absence-requests' => StudentAbsenceAuthorizationRequestController::class,

      'sanction-types' => SanctionTypeController::class,
      'sanctions' => SanctionController::class,

      'vacation-types' => VacationTypeController::class,
      'vacations' => VacationController::class,

      'doctors' => DoctorController::class,
      'medical-forms' => MedicalFormController::class,
      'appointment-requests' => AppointmentRequestController::class,

      'achievement-types' => AchievementTypeController::class,
      'achievements' => AchievementController::class ,

      'contract-types' => ContractTypeController::class ,
      'employment-contracts' => EmploymentContractController::class ,
      'absences' => AbsenceController::class ,

      'forms' => FormController::class ,
      'form-sections' => FormSectionController::class ,
      'form-questions' => FormQuestionController::class ,

      'participators' => ParticipatorController::class ,
      'pre-inscriptions' => PreInscriptionController::class ,
      'form-answers' => FormAnswerController::class ,
    ]);

    Route::apiResource('subscriptions.payment-schedules', PaymentScheduleController::class)->only('index');
    Route::post('subscriptions/{subscription}/payment-schedules/generate', [PaymentScheduleController::class, 'generate'],);
    Route::post('subscriptions/{subscription}/payment-schedules', [PaymentScheduleController::class, 'update'],);

  });
