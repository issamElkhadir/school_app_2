<?php

namespace Modules\Education\Database\factories;

use App\Models\School;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Education\Entities\Form;
use Modules\Education\Entities\Level;

class PreInscriptionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Education\Entities\PreInscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addDay();

        return [
            'title' => $this->faker->title(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->paragraph(2),
            'status' => $this->faker->boolean(),
            'start_date_time' => $startDate->format('Y-m-d H:i:s'), 
            'end_date_time' => $endDate->format('Y-m-d H:i:s'), 
            'form_id' => Form::factory()->create()->id,
            'school_id' => School::factory()->create()->id,
            'level_id' => Level::factory()->create()->id,
        ];
    }
}

