<?php

namespace Modules\Education\Database\factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicalFormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Education\Entities\MedicalForm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'school_id'=>School::factory(),
            'name'=>$this->faker->name(),
            'rtl_name'=>$this->faker->name(),
            'short_name'=>$this->faker->name(),
            'description'=>$this->faker->text(20),
            'status'=>$this->faker->boolean()
        ];
    }
}

