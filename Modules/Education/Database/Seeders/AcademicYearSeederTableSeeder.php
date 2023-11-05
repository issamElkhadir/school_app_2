<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Education\Entities\AcademicYear;

class AcademicYearSeederTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //        Model::unguard();
    AcademicYear::factory()->count(5)->create();
  }
}
