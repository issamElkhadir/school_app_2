<?php

namespace Tests\Feature\Models;

use App\Models\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\School;
use Tests\TestCase;

class SequenceTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['base.sequence.*']);
  }

  /** @test */
  public function can_create_a_sequence()
  {
    $school = School::factory()->create();

    $sequence = Sequence::factory()->make()->toArray();

    $sequence['school'] = $school->only(['id', 'name']);

    $response = $this->postJson(route('api.sequences.store'), $sequence);

    $response->assertStatus(201)
      ->assertJson(['data' => ['name' => $sequence['name']]]);
  }

  /** @test */
  public function can_show_a_sequence()
  {
    $school = School::factory()->create();

    $sequence = Sequence::factory()->create([
      'school_id' => $school->id,
    ]);

    $response = $this->getJson(route('api.sequences.show', $sequence->id));

    $response->assertStatus(200)
      ->assertJson(['data' => ['name' => $sequence->name]]);
  }

  /** @test */
  public function can_update_a_sequence()
  {
    $school = School::factory()->create();

    $sequence = Sequence::factory()->create([
      'school_id' => $school['id'],
    ]);

    $sequence['school'] = $school->only(['id', 'name']);

    $sequence['name'] = 'New Name';

    $response = $this->putJson(route('api.sequences.update', $sequence['id']), $sequence->toArray());

    $response->assertStatus(200)
      ->assertJson(['data' => ['name' => $sequence['name']]]);
  }

  /** @test */
  public function can_delete_a_sequence()
  {
    $school = School::factory()->create();

    $sequence = Sequence::factory()->create([
      'school_id' => $school['id'],
    ]);

    $response = $this->deleteJson(route('api.sequences.destroy', $sequence['id']));

    $response->assertNoContent()
      ->assertStatus(204)
      ->assertSee(null);

    $this->assertDatabaseMissing(Sequence::class, ['id' => $sequence['id']]);
  }

  /** @test */
  public function can_list_sequences()
  {
    $school = School::factory()->create();

    Sequence::factory()->count(5)->create([
      'school_id' => $school['id'],
    ]);

    $response = $this->getJson(route('api.sequences.index'));

    $response->assertStatus(200)
      ->assertJsonCount(5, 'data');
  }
}
