<?php

namespace Modules\Education\Database\factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Doctor;

class DoctorFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Doctor::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'school_id' => School::factory(),
      'name' => $this->faker->name(),
      'address' => $this->faker->address(),
      'phone' => $this->faker->phoneNumber(),
      'email' => $this->faker->email(),
      'speciality' => $this->faker->text(20)
    ];
  }
}

