<?php

namespace Database\Seeders;

use App\Models\MeasureUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeasureUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeasureUnit::factory()->count(10)->create();
    }
}
