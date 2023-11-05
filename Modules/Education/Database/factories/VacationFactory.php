<?php

namespace Modules\Education\Database\factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Staff;
use Modules\Education\Entities\VacationType;
use Modules\Education\Entities\Vacation;

class VacationFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Vacation::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'staff_id' => Staff::factory(),
      'start_date' => $this->faker->date(),
      'end_date' => $this->faker->date(),
      'vacation_type_id' => VacationType::factory(),

    ];
  }
}

