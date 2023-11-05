<?php

namespace Modules\Education\Database\factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Guardian;
use Modules\Education\Entities\Staff;
use Modules\Education\Entities\Student;

class AppointmentRequestFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\AppointmentRequest::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'school_id' => School::factory(),
      'staff_id' => Staff::factory(),
      'student_id' => Student::factory(),
      'guardian_id' => Guardian::factory(),
      'title' => $this->faker->title(),
      'content' => $this->faker->paragraph(2, true),
      'accepted' => $this->faker->boolean(),
      'response' => $this->faker->text(30),
      'appointment_date' => $this->faker->date(),
    ];
  }
}

