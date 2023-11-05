<?php

namespace Modules\Education\Database\factories;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Staff;
use Modules\Education\Entities\StaffAuthorizationRequest;

class StaffAuthorizationRequestFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = StaffAuthorizationRequest::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'staff_id' => Staff::factory(),
      'responsible_id' => User::factory(),
      'confirmed_date' => $this->faker->date(),
      'content' => $this->faker->text(),
      'start_date_time' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
      'end_date_time' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
      'note' => $this->faker->text(),
      'school_id' => School::factory(),
    ];
  }
}
