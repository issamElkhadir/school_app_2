<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $states = require base_path('database/data/states.php');

    collect($states)->chunk(1000)->each(function ($states) {
      State::query()->insert($states->toArray());
    });

    // Set the sequence to the highest id
    $maxId = State::query()->max('id') + 1;

    State::query()->getConnection()->statement("ALTER SEQUENCE states_id_seq RESTART WITH {$maxId}");
  }
}
