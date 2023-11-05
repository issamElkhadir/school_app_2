<?php

namespace Modules\Education\Database\factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Clazz;
use Modules\Education\Entities\Cycle;
use Modules\Education\Entities\PaymentBill;
use Modules\Education\Entities\Student;
use Modules\Education\Entities\Subscription;

class PaymentScheduleFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\PaymentSchedule::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'payment_bill_id' => PaymentBill::factory(),
      'amount_paid' => $this->faker->randomFloat(2, 0,100000),
      'payment_date' => $this->faker->date(),
      'invoicing_policy' => $this->faker->randomElement([1,2]),
      'amount_to_pay' => $this->faker->randomFloat(2, 0,100000),

    ];
  }
}
