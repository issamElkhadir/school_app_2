<?php

namespace Modules\Education\Database\factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Accounting\Entities\CashRegister;
use Modules\Education\Entities\Clazz;
use Modules\Education\Entities\Cycle;
use Modules\Education\Entities\Staff;
use Modules\Education\Entities\Student;
use Modules\Education\Entities\Subscription;

class PaymentFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Payment::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'payment_date' => $this->faker->date(),
      'currency_id' => Currency::factory(),
      'amount' => $this->faker->randomFloat(2, 0,100000),
      'destination_cash_register_id' => CashRegister::factory(),
      'source_cash_register_id' => CashRegister::factory(),
      'staff_id' => Staff::factory(),
      'payable_id' => Subscription::factory(),
      'payable_type' => 'Modules\Education\Entities\Subscription',
      'memo' => $this->faker->word(),
      'payment_method' => $this->faker->randomElement([1,2,3,4,5]),
      'customer_id' => Student::factory(),
      'customer_type' => 'Modules\Education\Entities\Staff'

    ];
  }
}
