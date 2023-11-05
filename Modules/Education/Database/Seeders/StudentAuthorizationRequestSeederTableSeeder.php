<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Education\Entities\StudentAuthorizationRequest;

class StudentAuthorizationRequestSeederTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    StudentAuthorizationRequest::factory()->count(10)->create();
  }
}
