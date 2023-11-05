<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;

class DiseaseTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    \Modules\Education\Entities\Disease::factory()->count(5)->create();
  }
}
