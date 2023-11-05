<?php

namespace Modules\Education\Database\factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class SanctionTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Education\Entities\SanctionType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'school_id' => School::factory(),
        'name' => $this->faker->word(),
        'rtl_name' => $this->faker->word(),
        'short_name' => $this->faker->word(),
        'description' => $this->faker->word(),
        'status' => $this->faker->boolean(),
    ];
    }
}

