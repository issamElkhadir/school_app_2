<?php

namespace Modules\Education\Tests\Feature;

use App\Models\School;
use Modules\Education\Entities\SanctionType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SanctionTypeTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.sanction-type.*']);
  }

  /** @test * */
  public function can_get_sanction_types()
  {
    $sanctionTypes = SanctionType::factory()->count(5);

    $school = School::factory()->create();

    $sanctionTypes->create([
      'school_id' => $school->id,
    ]);

    $response = $this->get(route('api.education.sanction-types.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');
;
  }

  /** @test * */
  public function can_create_sanction_type()
  {
    $sanctionType = SanctionType::factory()->makeOne()->toArray();

    $school = School::factory()->create();

    $sanctionType['school'] = $school->only(['id', 'name']);

    $response = $this->post(route('api.education.sanction-types.store'), $sanctionType);

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'school']])
      ->assertStatus(201);
  }

  /** @test * */
  public function can_update_sanction_type()
  {
    $school = School::factory()->create();

    $sanctionType = SanctionType::factory()->create([
      'school_id' => $school->id,
    ]);

    $sanctionType['school'] = $school->only(['id', 'name']);

    $response = $this->put(route('api.education.sanction-types.update', $sanctionType->id), $sanctionType->toArray());

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'school']])
      ->assertStatus(200);
  }


  /** @test * */
  public function can_show_sanction_type()
  {
    $school = School::factory()->create();

    $sanctionType = SanctionType::factory()->create([
      'school_id' => $school->id,

    ]);

    $response = $this->get(route('api.education.sanction-types.show', $sanctionType->id));

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'school']])
      ->assertStatus(200);

    $this->assertEquals($sanctionType->id, $response->json('data.id'));

  }

  /** @test * */
  public function can_delete_sanction_type()
  {
    $school = School::factory()->create();

    $sanctionType = SanctionType::factory()->create([
      'school_id' => $school->id,

    ]);

    $response = $this->delete(route('api.education.sanction-types.destroy', $sanctionType->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('sanction_types', [
      'id' => $sanctionType->id
    ]);
  }
}
