<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Education\Entities\SubjectSequence;

class SubjectSequenceSeederTableSeeder extends Seeder
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
      SubjectSequence::factory()->count(10)->create();
    }
}
