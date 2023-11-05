<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Education\Entities\StudentAbsenceAuthorizationRequest;

class StudentAbsenceAuthorizationRequestSeederTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    StudentAbsenceAuthorizationRequest::factory()->count(10)->create();
  }
}
