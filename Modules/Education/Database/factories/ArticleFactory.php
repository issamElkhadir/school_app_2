<?php

namespace Modules\Education\Database\factories;

use App\Models\Currency;
use App\Models\MeasureUnit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Category;

class ArticleFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\Article::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->name(),
      'rtl_name' => $this->faker->name(),
      'category_id' => Category::factory(),
      'product_type' => $this->faker->randomElement(['product', 'service']),
      'invoicing_policy' => $this->faker->randomElement([1, 2]),
      'unit_id' => MeasureUnit::factory(),
      'currency_id' => Currency::inRandomOrder()->first()->id ?? null,
      'sale_price' => $this->faker->randomFloat(2, 0, 1000),
      'vat' => $this->faker->randomFloat(2, 0, 1000),
      'default_code' => $this->faker->numerify('########'),
      'barcode' => $this->faker->numerify('########'),

    ];
  }
}
