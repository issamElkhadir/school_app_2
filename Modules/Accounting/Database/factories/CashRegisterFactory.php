<?php

namespace Modules\Accounting\Database\factories;

use App\Models\Currency;
use App\Models\MeasureUnit;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Category;

class CashRegisterFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Accounting\Entities\CashRegister::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->name(),
      'rtl_name' => fake('ar')->name(),
      'status' => $this->faker->boolean(),
      'is_real' => $this->faker->boolean(),
      'owner_id' => School::factory(),
      'owner_type' => $this->faker->randomElement(['Modules\Education\Entities\School']),
      'initial_balance' => $this->faker->randomFloat(2, 0, 1000),

    ];
  }
}
