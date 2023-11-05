<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Education\Entities\PreInscription;

class EducationDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //    Model::unguard();

    $this->call([
          //  GuardianSeederTableSeeder::class,
          //  StaffSeederTableSeeder::class,
          //  StudentSeederTableSeeder::class,
          //  AcademicYearSeederTableSeeder::class,
          //  ClassroomTypeSeederTableSeeder::class,
          //  ClassroomSeederTableSeeder::class,
          //  CycleSeederTableSeeder::class,
          //  BranchSeederTableSeeder::class,
          //  LevelSeederTableSeeder::class,
          //  UnitySeederTableSeeder::class,
          //  PeriodSeederTableSeeder::class,
          //  SubjectSeederTableSeeder::class,
          //  SubjectSequenceSeederTableSeeder::class,
          //  ClassSeederTableSeeder::class,

          //  CategorySeederTableSeeder::class,
          //  ArticleSeederTableSeeder::class,
          //  PackSeederTableSeeder::class,
          //  SubscriptionSeederTableSeeder::class,
          //  PaymentBillSeederTableSeeder::class,
          //  PaymentBillLineSeederTableSeeder::class,
          //  PaymentScheduleSeederTableSeeder::class,
            //  PaymentSeederTableSeeder::class,
            //  AbsenceTypeSeederTableSeeder::class,
            //  EventCategorySeederTableSeeder::class,
          //  SkillSeederTableSeeder::class,
          //  SessionSeederTableSeeder::class,
          //  StaffAuthorizationRequestSeederTableSeeder::class,
          //  StudentAuthorizationRequestSeederTableSeeder::class,
          //  StudentAbsenceAuthorizationRequestSeederTableSeeder::class,
          //  AllergyTypeSeederTableSeeder::class,
          //  AllergySeederTableSeeder::class,
      
          //  SanctionTypeSeederTableSeeder::class,
          //  SanctionSeederTableSeeder::class,


      //      VacationTypeSeeder::class,
      //      VacationSeeder::class,

      //      DoctorSeederTableSeeder::class,
      //      MedicalFormSeederTableSeeder::class,
      //      AppointmentRequestSeederTableSeeder::class,

      // AchievementTypeSeederTableSeeder::class,
      // AchievementSeederTableSeeder::class ,
      
      // ContractTypeSeederTableSeeder::class ,
      // EmploymentContractSeederTableSeeder::class ,
      // AbsenceSeederTableSeeder::class
      FormSeederTableSeeder::class ,
      FormSectionSeederTableSeeder::class ,
      FormQuestionSeederTableSeeder::class ,
      ParticipatorSeederTableSeeder::class ,
      PreInscriptionSeederTableSeeder::class ,
      FormAnswerSeederTableSeeder::class
    ]);
  }
}
