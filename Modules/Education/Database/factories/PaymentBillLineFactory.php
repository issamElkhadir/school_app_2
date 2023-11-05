<?php

namespace Modules\Education\Database\factories;

use App\Models\Currency;
use App\Models\MeasureUnit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Clazz;
use Modules\Education\Entities\Cycle;
use Modules\Education\Entities\Pack;
use Modules\Education\Entities\PaymentBill;
use Modules\Education\Entities\Student;
use Modules\Education\Entities\Subscription;

class PaymentBillLineFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\PaymentBillLine::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->word(),
      'payment_bill_id' => PaymentBill::factory(),
      'unit_id' => MeasureUnit::factory(),
      'quantity' => $this->faker->randomFloat(2, 0,100000),
      'price_unit' => $this->faker->randomFloat(2, 0,100000),
      'vat' => $this->faker->randomFloat(2, 0,100000),
      'subtotal' => $this->faker->randomFloat(2, 0,100000),
      'item_id' => Pack::factory(),
      'item_type' => $this->faker->randomElement(['Modules\Education\Entities\Pack', 'Modules\Education\Entities\Article']),



    ];
  }
}
