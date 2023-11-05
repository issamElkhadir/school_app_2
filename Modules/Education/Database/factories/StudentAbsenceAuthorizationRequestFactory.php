<?php

namespace Modules\Education\Database\factories;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\StudentAbsenceAuthorizationRequest;
use Modules\Education\Entities\Subscription;

class StudentAbsenceAuthorizationRequestFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = StudentAbsenceAuthorizationRequest::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'subscription_id' => Subscription::factory(),
      'accepted_by' => User::factory(),
      'start_date' => $this->faker->date(),
      'end_date' => $this->faker->date(),
      'accepted' => $this->faker->boolean(),
      'content' => $this->faker->text(),
      'file' => $this->faker->text(),
      'authorization_date' => $this->faker->date(),
      'school_id' => School::factory(),
    ];
  }
}

