<?php

namespace Modules\Education\Database\factories;

use App\Models\Currency;
use App\Models\MeasureUnit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Article;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Category;
use Modules\Education\Entities\Level;
use Modules\Education\Entities\Pack;

class PackArticleFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \Modules\Education\Entities\PackArticle::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {

    return [
      'pack_id' => Pack::factory(),
      'article_id' => Article::factory(),
      'currency_id' => Currency::factory(),
      'discount' => $this->faker->randomFloat(2, 0, 1000),
      'sale_price' => $this->faker->randomFloat(2, 0, 1000),
      'vat' => $this->faker->randomFloat(2, 0, 1000),

    ];
  }
}
