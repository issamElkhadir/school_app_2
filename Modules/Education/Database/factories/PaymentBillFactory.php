<?php

namespace Modules\Education\Database\factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Clazz;
use Modules\Education\Entities\Cycle;
use Modules\Education\Entities\Student;
use Modules\Education\Entities\Subscription;

class PaymentBillFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\PaymentBill::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'sequence' => $this->faker->word(),
      'subscription_id' => Subscription::factory(),
      'untaxed_amount' => $this->faker->randomFloat(2, 0,100000),
      'tax_amount' => $this->faker->randomFloat(2, 0,100000),
      'total_amount' => $this->faker->randomFloat(2, 0,100000),
      'paid_amount' => $this->faker->randomFloat(2, 0,100000),
      'unpaid_amount' => $this->faker->randomFloat(2, 0,100000),
      'currency_id' => Currency::factory(),

    ];
  }
}
