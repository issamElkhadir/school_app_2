<?php

namespace Modules\Education\Database\factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Achievement;
use Modules\Education\Entities\AchievementType;
use Modules\Education\Entities\Clazz;
use Modules\Education\Entities\Session;

class AchievementFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Achievement::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'achievable_id' => Session::factory(),
      'achievable_type' => 'education.session',
      'class_id' => Clazz::factory(),
      'start_time' => $this->faker->time('H:i:s'),
      'end_time' => $this->faker->time('H:i:s'),
      'date' => $this->faker->date(),
      'achievement_type_id' => AchievementType::factory(),
      'is_realised' => $this->faker->boolean(),
      'delay_time' => '00:00:00',
      'note' => $this->faker->word(),
      'school_id' => School::factory()
    ];
  }
}

