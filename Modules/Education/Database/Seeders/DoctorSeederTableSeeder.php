<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Education\Entities\Doctor;

class DoctorSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();

        // $this->call("OthersTableSeeder");
        Doctor::factory()->count(10)->create();
    }
}
