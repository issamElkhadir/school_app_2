<?php

namespace Modules\Education\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Education\Entities\Guardian;
use Modules\Education\Entities\Staff;

class StaffSeederTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    // get user with id 1 (super-admin)
    /** @var User */
    $user = User::find(1);

    $staff = Staff::factory()->create();

    // link user with staff if not exists
    if (is_null($user->profile)) {
      $user->profile()->associate($staff);
      $user->save();
    }

    // create staff for user with id 1
    $staff = Staff::factory()->count(10)->create();

  }
}
