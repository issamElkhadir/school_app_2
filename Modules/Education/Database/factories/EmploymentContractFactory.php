<?php

namespace Modules\Education\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\ContractType;
use Modules\Education\Entities\Staff;

class EmploymentContractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Education\Entities\EmploymentContract::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'staff_id' => Staff::factory() ,
            'contract_start_date' => $this->faker->date(),
            'contract_end_date' => $this->faker->date(),
            'net_salary' => $this->faker->randomFloat(2,10,100000),
            'brut_salary' => $this->faker->randomFloat(2,10,100000),
            'nbr_days_off' => $this->faker->numberBetween(1 , 1000) ,
            'contract_type_id' => ContractType::factory()
        ];
    }
}

