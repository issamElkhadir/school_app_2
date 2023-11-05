<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $countries = require base_path('database/data/countries.php');

    // Fill created_at and updated_at
    $countries = array_map(function ($country) {
      $country['created_at'] = now();
      $country['updated_at'] = now();

      return $country;
    }, $countries);

    Country::query()->insert($countries);

    // Set the sequence to the highest id
    $maxId = Country::query()->max('id') + 1;

    Country::query()->getConnection()->statement("ALTER SEQUENCE countries_id_seq RESTART WITH {$maxId}");
  }
}
