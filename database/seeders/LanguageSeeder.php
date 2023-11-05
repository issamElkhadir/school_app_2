<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Language::factory()->create([
      'name' => 'English',
      'direction' => 'ltr',
      'iso_code' => 'en',
      'url_code' => 'en',
      'status' => true,
      'local_code' => 'en_EN',
    ]);

    Language::factory()->create([
      'name' => 'Arabic',
      'direction' => 'ltr',
      'iso_code' => 'ar',
      'url_code' => 'ar',
      'status' => true,
      'local_code' => 'ar_MA',
    ]);

    Language::factory()->create([
      'name' => 'Spanish',
      'direction' => 'ltr',
      'iso_code' => 'es',
      'url_code' => 'es',
      'status' => true,
      'local_code' => 'es_ES',
    ]);

    // Language::factory()->count(10)->create();
  }
}
