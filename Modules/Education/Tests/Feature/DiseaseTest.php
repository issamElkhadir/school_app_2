<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\Disease;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiseaseTest extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser([]);
  }

  /** @test */
  public function can_create_disease()
  {
    $disease = Disease::factory()->makeOne()->toArray();

    $disease['school'] = ['id' => $disease['school_id']];

    $response = $this->postJson(route('api.education.diseases.store'), $disease);

    $response->assertStatus(201);

    $this->assertDatabaseHas('diseases', [
      'name' => $disease['name'],
    ]);
  }

  /** @test */
  public function can_update_disease()
  {
    $disease = Disease::factory()->create()->toArray();

    $disease['name'] = 'New Name';

    $response = $this->putJson(route('api.education.diseases.update', $disease['id']), $disease);

    $response->assertStatus(200);

    $this->assertDatabaseHas('diseases', [
      'name' => $disease['name'],
    ]);
  }

  /** @test */
  public function can_delete_disease()
  {
    $disease = Disease::factory()->create()->toArray();

    $response = $this->deleteJson(route('api.education.diseases.destroy', $disease['id']));

    $response->assertNoContent();

    $this->assertDatabaseMissing('diseases', [
      'name' => $disease['name'],
    ]);
  }

  /** @test */
  public function can_show_disease()
  {
    $disease = Disease::factory()->create()->toArray();

    $response = $this->getJson(route('api.education.diseases.show', $disease['id']));

    $response
      ->assertSuccessful()
      ->assertJsonStructure([
        'data' => [
          'id',
          'name',
          'description',
          'symptoms',
          'treatment',
        ]
      ]);
  }

  /** @test */
  public function can_get_diseases()
  {
    Disease::factory()->count(5)->create();

    $response = $this->getJson(route('api.education.diseases.index'));

    $response
      ->assertSuccessful()
      ->assertJsonCount(5, 'data')
      ->assertJsonStructure([
        'data' => [
          '*' => [
            'id',
            'name',
            'description',
            'symptoms',
            'treatment',
          ]
        ]
      ]);
  }
}
