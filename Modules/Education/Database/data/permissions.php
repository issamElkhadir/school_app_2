<?php

use App\Permissions\PermissionBlueprint;
use App\Permissions\PermissionDescriptor;
use Modules\Education\Entities\Absence;
use Modules\Education\Entities\AbsenceType;
use Modules\Education\Entities\AcademicYear;
use Modules\Education\Entities\Achievement;
use Modules\Education\Entities\AchievementType;
use Modules\Education\Entities\Allergy;
use Modules\Education\Entities\AllergyType;
use Modules\Education\Entities\AppointmentRequest;
use Modules\Education\Entities\Article;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Category;
use Modules\Education\Entities\Classroom;
use Modules\Education\Entities\ClassroomType;
use Modules\Education\Entities\Clazz;
use Modules\Education\Entities\ContractType;
use Modules\Education\Entities\Cycle;
use Modules\Education\Entities\Disease;
use Modules\Education\Entities\Doctor;
use Modules\Education\Entities\EmploymentContract;
use Modules\Education\Entities\Form;
use Modules\Education\Entities\FormAnswer;
use Modules\Education\Entities\FormQuestion;
use Modules\Education\Entities\FormSection;
use Modules\Education\Entities\Guardian;
use Modules\Education\Entities\Level;
use Modules\Education\Entities\MedicalForm;
use Modules\Education\Entities\Pack;
use Modules\Education\Entities\Participator;
use Modules\Education\Entities\Payment;
use Modules\Education\Entities\PaymentBill;
use Modules\Education\Entities\PaymentBillLine;
use Modules\Education\Entities\PaymentSchedule;
use Modules\Education\Entities\Period;
use Modules\Education\Entities\PreInscription;
use Modules\Education\Entities\Sanction;
use Modules\Education\Entities\SanctionType;
use Modules\Education\Entities\Staff;
use Modules\Education\Entities\StaffAuthorizationRequest;
use Modules\Education\Entities\Student;
use Modules\Education\Entities\StudentAbsenceAuthorizationRequest;
use Modules\Education\Entities\StudentAuthorizationRequest;
use Modules\Education\Entities\Subject;
use Modules\Education\Entities\SubjectSequence;
use Modules\Education\Entities\Subscription;
use Modules\Education\Entities\Unity;
use Modules\Education\Entities\Vacation;
use Modules\Education\Entities\VacationType;

return PermissionDescriptor::make()
  ->inModule('education', function (PermissionBlueprint $blueprint) {
    // Staff Permissions
    $blueprint->forModel(Staff::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List Staff');
      $blueprint->add('show', 'Show Staff');
      $blueprint->add('store', 'Store Staff');
      $blueprint->add('update', 'Update Staff');
      $blueprint->add('destroy', 'Delete Staff');
    });

    // Guardian Permissions
    $blueprint->forModel(Guardian::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List Guardian');
      $blueprint->add('show', 'Show Guardian');
      $blueprint->add('store', 'Store Guardian');
      $blueprint->add('update', 'Update Guardian');
      $blueprint->add('destroy', 'Delete Guardian');
    });

    // Student Permissions
    $blueprint->forModel(Student::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List Student');
      $blueprint->add('show', 'Show Student');
      $blueprint->add('store', 'Store Student');
      $blueprint->add('update', 'Update Student');
      $blueprint->add('destroy', 'Delete Student');
    });

    // Subject Permissions
    $blueprint->forModel(Subject::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List Subject');
      $blueprint->add('show', 'Show Subject');
      $blueprint->add('store', 'Store Subject');
      $blueprint->add('update', 'Update Subject');
      $blueprint->add('destroy', 'Delete Subject');
    });

    // Subject Sequence Permissions
    $blueprint->forModel(SubjectSequence::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List Subject Sequence');
      $blueprint->add('show', 'Show Subject Sequence');
      $blueprint->add('store', 'Store Subject Sequence');
      $blueprint->add('update', 'Update Subject Sequence');
      $blueprint->add('destroy', 'Delete Subject Sequence');
    });

    // Academic Year Permissions
    $blueprint->forModel(AcademicYear::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List Academic Year');
      $blueprint->add('show', 'Show Academic Year');
      $blueprint->add('store', 'Store Academic Year');
      $blueprint->add('update', 'Update Academic Year');
      $blueprint->add('destroy', 'Delete Academic Year');
    });

    // Cycle Permissions
    $blueprint->forModel(Cycle::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List Cycle');
      $blueprint->add('show', 'Show Cycle');
      $blueprint->add('store', 'Store Cycle');
      $blueprint->add('update', 'Update Cycle');
      $blueprint->add('destroy', 'Delete Cycle');
    });

    // Level Permissions
    $blueprint->forModel(Level::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List Level');
      $blueprint->add('show', 'Show Level');
      $blueprint->add('store', 'Store Level');
      $blueprint->add('update', 'Update Level');
      $blueprint->add('destroy', 'Delete Level');
    });

    // Classroom Permissions
    $blueprint->forModel(Classroom::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List Classroom');
      $blueprint->add('show', 'Show Classroom');
      $blueprint->add('store', 'Store Classroom');
      $blueprint->add('update', 'Update Classroom');
      $blueprint->add('destroy', 'Delete Classroom');
    });

    // Branch Permissions
    $blueprint->forModel(Branch::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List branch');
      $blueprint->add('show', 'Show branch');
      $blueprint->add('store', 'Store branch');
      $blueprint->add('update', 'Update branch');
      $blueprint->add('destroy', 'Delete branch');
    });

    // Period Permissions
    $blueprint->forModel(Period::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List period');
      $blueprint->add('show', 'Show period');
      $blueprint->add('store', 'Store period');
      $blueprint->add('update', 'Update period');
      $blueprint->add('destroy', 'Delete period');
    });

    // Unity Permissions
    $blueprint->forModel(Unity::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List Unity');
      $blueprint->add('show', 'Show Unity');
      $blueprint->add('store', 'Store Unity');
      $blueprint->add('update', 'Update Unity');
      $blueprint->add('destroy', 'Delete Unity');
    });

    // Classroom Type Permissions
    $blueprint->forModel(ClassroomType::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List Classroom Type');
      $blueprint->add('show', 'Show Classroom Type');
      $blueprint->add('store', 'Store Classroom Type');
      $blueprint->add('update', 'Update Classroom Type');
      $blueprint->add('destroy', 'Delete Classroom Type');
    });

    // Class Permissions
    $blueprint->forModel(Clazz::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('education.class.index', 'List class', qualify: false);
      $blueprint->add('education.class.show', 'Show class', qualify: false);
      $blueprint->add('education.class.store', 'Store class', qualify: false);
      $blueprint->add('education.class.update', 'Update class', qualify: false);
      $blueprint->add('education.class.destroy', 'Delete class', qualify: false);
    });

    // Category Permissions
    $blueprint->forModel(Category::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List category');
      $blueprint->add('show', 'Show category');
      $blueprint->add('store', 'Store category');
      $blueprint->add('update', 'Update category');
      $blueprint->add('destroy', 'Delete category');
    });

    // Article Permissions
    $blueprint->forModel(Article::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List article');
      $blueprint->add('show', 'Show article');
      $blueprint->add('store', 'Store article');
      $blueprint->add('update', 'Update article');
      $blueprint->add('destroy', 'Delete article');
    });

    // Pack Permissions
    $blueprint->forModel(Pack::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List pack');
      $blueprint->add('show', 'Show pack');
      $blueprint->add('store', 'Store pack');
      $blueprint->add('update', 'Update pack');
      $blueprint->add('destroy', 'Delete pack');
    });

    // Subscription Permissions
    $blueprint->forModel(Subscription::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List subscription');
      $blueprint->add('show', 'Show subscription');
      $blueprint->add('store', 'Store subscription');
      $blueprint->add('update', 'Update subscription');
      $blueprint->add('destroy', 'Delete subscription');
    });

    // Payment Bill Permissions
    $blueprint->forModel(PaymentBill::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List payment bill');
      $blueprint->add('show', 'Show payment bill');
      $blueprint->add('store', 'Store payment bill');
      $blueprint->add('update', 'Update payment bill');
      $blueprint->add('destroy', 'Delete payment bill');
    });

    // Payment Bill Line Permissions
    $blueprint->forModel(PaymentBillLine::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List payment bill line');
      $blueprint->add('show', 'Show payment bill line');
      $blueprint->add('store', 'Store payment bill line');
      $blueprint->add('update', 'Update payment bill line');
      $blueprint->add('destroy', 'Delete payment bill line');
    });

    // Payment Schedule Permissions
    $blueprint->forModel(PaymentSchedule::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List payment schedule');
      $blueprint->add('show', 'Show payment schedule');
      $blueprint->add('store', 'Store payment schedule');
      $blueprint->add('update', 'Update payment schedule');
      $blueprint->add('destroy', 'Delete payment schedule');
    });

    // Payment Permissions
    $blueprint->forModel(Payment::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List payment');
      $blueprint->add('show', 'Show payment');
      $blueprint->add('store', 'Store payment');
      $blueprint->add('update', 'Update payment');
      $blueprint->add('destroy', 'Delete payment');
    });

    // Session Permissions
    $blueprint->forModel(\Modules\Education\Entities\Session::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List session');
      $blueprint->add('show', 'Show session');
      $blueprint->add('store', 'Store session');
      $blueprint->add('update', 'Update session');
      $blueprint->add('destroy', 'Delete session');
    });

    // Disease Permissions
    $blueprint->forModel(Disease::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List diseases');
      $blueprint->add('show', 'Show disease');
      $blueprint->add('store', 'Store disease');
      $blueprint->add('update', 'Update disease');
      $blueprint->add('destroy', 'Delete disease');
    });

    // Student Absence Authorization Request Permissions
    $blueprint->forModel(StudentAbsenceAuthorizationRequest::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List student absence authorization request');
      $blueprint->add('show', 'Show student absence authorization request');
      $blueprint->add('store', 'Store student absence authorization request');
      $blueprint->add('update', 'Update student absence authorization request');
      $blueprint->add('destroy', 'Delete student absence authorization request');
    });

    // vacation_types Permissions
    $blueprint->forModel(VacationType::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List vacation_types');
      $blueprint->add('show', 'Show vacation_types');
      $blueprint->add('store', 'Store vacation_types');
      $blueprint->add('update', 'Update vacation_types');
      $blueprint->add('destroy', 'Delete vacation_types');
    });

    // vacation Permissions
    $blueprint->forModel(Vacation::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List vacation');
      $blueprint->add('show', 'Show vacation');
      $blueprint->add('store', 'Store vacation');
      $blueprint->add('update', 'Update vacation');
      $blueprint->add('destroy', 'Delete vacation');
    });

    // Student Authorization Request Permissions
    $blueprint->forModel(StudentAuthorizationRequest::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List student authorization request');
      $blueprint->add('show', 'Show student authorization request');
      $blueprint->add('store', 'Store student authorization request');
      $blueprint->add('update', 'Update student authorization request');
      $blueprint->add('destroy', 'Delete student authorization request');
    });

    // Staff Authorization Request Permissions
    $blueprint->forModel(StaffAuthorizationRequest::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List staff authorization request');
      $blueprint->add('show', 'Show staff authorization request');
      $blueprint->add('store', 'Store staff authorization request');
      $blueprint->add('update', 'Update staff authorization request');
      $blueprint->add('destroy', 'Delete staff authorization request');
    });

    // Allergy Type Permissions
    $blueprint->forModel(AllergyType::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List allergy type');
      $blueprint->add('show', 'Show allergy type');
      $blueprint->add('store', 'Store allergy type');
      $blueprint->add('update', 'Update allergy type');
      $blueprint->add('destroy', 'Delete allergy type');
    });

    // Allergy Permissions
    $blueprint->forModel(Allergy::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List allergy');
      $blueprint->add('show', 'Show allergy');
      $blueprint->add('store', 'Store allergy');
      $blueprint->add('update', 'Update allergy');
      $blueprint->add('destroy', 'Delete allergy');
    });

    // Sanction Type Permissions
    $blueprint->forModel(SanctionType::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List sanction type');
      $blueprint->add('show', 'Show sanction type');
      $blueprint->add('store', 'Store sanction type');
      $blueprint->add('update', 'Update sanction type');
      $blueprint->add('destroy', 'Delete sanction type');
    });

    // Sanction Permissions
    $blueprint->forModel(Sanction::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List sanction');
      $blueprint->add('show', 'Show sanction');
      $blueprint->add('store', 'Store sanction');
      $blueprint->add('update', 'Update sanction');
      $blueprint->add('destroy', 'Delete sanction');
    });

    // doctor permissions
    $blueprint->forModel(Doctor::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List doctor');
      $blueprint->add('show', 'Show doctor');
      $blueprint->add('store', 'Store doctor');
      $blueprint->add('update', 'Update doctor');
      $blueprint->add('destroy', 'Delete doctor');
    });

    // medical form permissions
    $blueprint->forModel(MedicalForm::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List medical form');
      $blueprint->add('show', 'Show medical form');
      $blueprint->add('store', 'Store medical form');
      $blueprint->add('update', 'Update medical form');
      $blueprint->add('destroy', 'Delete medical form');
    });

    // appointment request permissions
    $blueprint->forModel(AppointmentRequest::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List appointment request');
      $blueprint->add('show', 'Show appointment request');
      $blueprint->add('store', 'Store appointment request');
      $blueprint->add('update', 'Update appointment request');
      $blueprint->add('destroy', 'Delete appointment request');
    });

    // Achievement Type  Permissions
    $blueprint->forModel(AchievementType::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List achievement type');
      $blueprint->add('show', 'Show achievement type');
      $blueprint->add('store', 'Store achievement type');
      $blueprint->add('update', 'Update achievement type');
      $blueprint->add('destroy', 'Delete achievement type');
    });

    // Achievement  Permissions
    $blueprint->forModel(Achievement::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List achievement');
      $blueprint->add('show', 'Show achievement');
      $blueprint->add('store', 'Store achievement');
      $blueprint->add('update', 'Update achievement');
      $blueprint->add('destroy', 'Delete achievement');
    });

    // Contract Type  Permissions
    $blueprint->forModel(ContractType::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List contract type');
      $blueprint->add('show', 'Show contract type');
      $blueprint->add('store', 'Store contract type');
      $blueprint->add('update', 'Update contract type');
      $blueprint->add('destroy', 'Delete contract type');
    });

    // Employment Contract  Permissions
    $blueprint->forModel(EmploymentContract::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List employment contract');
      $blueprint->add('show', 'Show employment contract');
      $blueprint->add('store', 'Store employment contract');
      $blueprint->add('update', 'Update employment contract');
      $blueprint->add('destroy', 'Delete employment contract');
    });


    // Absence  Permissions
    $blueprint->forModel(Absence::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List absences');
      $blueprint->add('show', 'Show absence');
      $blueprint->add('store', 'Store absence');
      $blueprint->add('update', 'Update absence');
      $blueprint->add('destroy', 'Delete absence');
    });

    // Absence  Permissions
    $blueprint->forModel(AbsenceType::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List absence types');
      $blueprint->add('show', 'Show absence type');
      $blueprint->add('store', 'Store absence type');
      $blueprint->add('update', 'Update absence type');
      $blueprint->add('destroy', 'Delete absence type');
    });


    // forms permissions
    $blueprint->forModel(Form::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List forms');
      $blueprint->add('show', 'Show form');
      $blueprint->add('store', 'Store form');
      $blueprint->add('update', 'Update form');
      $blueprint->add('destroy', 'Delete form');
    });
    // form sections permissions
    $blueprint->forModel(FormSection::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List  form sections');
      $blueprint->add('show', 'Show  form section');
      $blueprint->add('store', 'Store  form section');
      $blueprint->add('update', 'Update  form section');
      $blueprint->add('destroy', 'Delete  form section');
    });
    // form questions permissions
    $blueprint->forModel(FormQuestion::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List  form questions');
      $blueprint->add('show', 'Show  form question');
      $blueprint->add('store', 'Store  form question');
      $blueprint->add('update', 'Update  form question');
      $blueprint->add('destroy', 'Delete  form question');
    });

    // pre_inscriptions permissions
    $blueprint->forModel(PreInscription::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List  form pre_inscriptions');
      $blueprint->add('show', 'Show  form pre_inscription');
      $blueprint->add('store', 'Store  form pre_inscription');
      $blueprint->add('update', 'Update  form pre_inscription');
      $blueprint->add('destroy', 'Delete  form pre_inscription');
    });
    
    // participators permissions
    $blueprint->forModel(Participator::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List  form participators');
      $blueprint->add('show', 'Show  form participator');
      $blueprint->add('store', 'Store  form participator');
      $blueprint->add('update', 'Update  form participator');
      $blueprint->add('destroy', 'Delete  form participator');
    });
    // form answers permissions
    $blueprint->forModel(FormAnswer::class, function (PermissionBlueprint $blueprint) {
      $blueprint->add('index', 'List  form answers');
      $blueprint->add('show', 'Show  form answer');
      $blueprint->add('store', 'Store  form answer');
      $blueprint->add('update', 'Update  form answer');
      $blueprint->add('destroy', 'Delete  form answer');
    });

  });


