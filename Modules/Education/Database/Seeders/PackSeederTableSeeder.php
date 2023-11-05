<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Education\Entities\Article;
use Modules\Education\Entities\Category;
use Modules\Education\Entities\Pack;

class PackSeederTableSeeder extends Seeder
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
      Pack::factory()->count(10)->create();
    }
}
