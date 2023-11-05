<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Education\Entities\Category;
use Modules\Education\Entities\Subscription;

class SubscriptionSeederTableSeeder extends Seeder
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
      Subscription::factory()->count(10)->create();
    }
}
