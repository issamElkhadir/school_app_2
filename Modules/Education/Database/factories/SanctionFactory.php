<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Sanction;
use Modules\Education\Entities\SanctionType;
use Modules\Education\Entities\Staff;

class SanctionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sanction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'staff_id' => staff::factory(),
          'date' => $this->faker->date(),
          'reason' => $this->faker->sentence(),
          'description' => $this->faker->paragraph(),
          'decision' => $this->faker->word(),
          'sanction_type_id' => SanctionType::factory(),
      ];
    }
}

