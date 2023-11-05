<?php

namespace Modules\Education\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Category;
use Modules\Education\Entities\PaymentBill;

class PaymentBillSeederTableSeeder extends Seeder
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
      PaymentBill::factory()->count(10)->create();
    }
}
