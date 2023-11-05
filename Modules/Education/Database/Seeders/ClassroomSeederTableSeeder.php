<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Education\Entities\Classroom;

class ClassroomSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Model::unguard();

        // $this->call("OthersTableSeeder");
      Classroom::factory()->count(10)->create();
    }
}
