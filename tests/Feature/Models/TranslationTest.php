<?php

namespace Models;

use App\Models\Language;
use App\Models\Translation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TranslationTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['base.translation.*']);
  }

  /** @test */
  public function can_create_translation()
  {
    $language = Language::factory()->create();

    $translation = Translation::factory()->makeOne()->toArray();

    $translation['language'] = $language->only(['id', 'value']);

    $response = $this->postJson(route('api.translations.store'), $translation);

    $response->assertStatus(201)
      ->assertJson(['data' => ['value' => $translation['value']]]);
  }

  /** @test */
  public function can_show_translation()
  {
    $language = Language::factory()->create();

    $translation = Translation::factory()
      ->create([
        'language_id' => $language->id,
      ]);

    $response = $this->getJson(route('api.translations.show', $translation->id));

    $response->assertStatus(200);

    $response->assertJson(['data' => ['value' => $translation->value]]);
  }

  /** @test */
  public function can_update_translation()
  {
    $language = Language::factory()->create();

    $translation = Translation::factory()
      ->for($language)
      ->create();

    $translation->value = 'Updated';

    $attributes = $translation->toArray();

    $attributes['language'] = $language->only(['id', 'value']);

    $response = $this->putJson(route('api.translations.update', $translation->id), $attributes);

    $response->assertStatus(200);

    $response->assertJson(['data' => ['value' => $translation->value]]);
  }


  /** @test */
  public function can_delete_translation()
  {
    $translation = Translation::factory()
      ->for(Language::factory())
      ->create();

    $response = $this->deleteJson(route('api.translations.destroy', $translation->id));

    $response->assertNoContent();

    $this->assertDatabaseMissing('translations', ['id' => $translation->id]);
  }

  /** @test */
  public function can_get_translations()
  {
    $language = Language::factory()->create();

    $translation = Translation::factory()
      ->for($language)
      ->create();

    $response = $this->getJson(route('api.translations.index'));

    $response->assertStatus(200);

    $response->assertJson(['data' => [['value' => $translation->value]]]);
  }

  /** @test */
  public function can_get_translations_with_language()
  {
    $translation = Translation::factory()
      ->for(Language::factory())
      ->create();

    $response = $this->getJson(route('api.translations.index', ['include' => 'language']));

    $response->assertStatus(200);

    $response->assertJsonStructure([
      'data' => [
        '*' => [
          'id',
          'language',
          'module',
          'model',
          'value',
          'key',
        ],
      ],
    ]);
  }
}
