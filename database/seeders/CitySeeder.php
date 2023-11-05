<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $cities = require base_path('database/data/cities.php');

    // Save all cities to DB
    collect($cities)->chunk(1000)->each(function ($cities) {
      City::query()->insert($cities->toArray());
    });

    // Set the sequence to the highest id
    $maxId = City::query()->max('id') + 1;

    City::query()->getConnection()->statement("ALTER SEQUENCE cities_id_seq RESTART WITH {$maxId}");
  }
}
