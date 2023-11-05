<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\Allergy;
use Modules\Education\Entities\AllergyType;
use App\Models\School;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllergyTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.allergy.*']);
  }

  /** @test */
  public function can_get_allergies()
  {
    $allergy = Allergy::factory()->count(5);

    $school = School::factory()->create();
    $allergyType = AllergyType::factory()->create();

    $allergy->create([
      'school_id' => $school->id,
      'allergy_type_id' => $allergyType->id,
    ]);

    $response = $this->get(route('api.education.allergies.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_allergy()
  {
    $allergy = Allergy::factory()->makeOne()->toArray();

    $school = School::factory()->create();

    $allergyType = AllergyType::factory()->create();

    $allergy['school'] = $school->only('id', 'name');

    $allergy['allergy_type'] = $allergyType->only('id', 'name');

    $response = $this->post(route('api.education.allergies.store'), $allergy);

    $response->assertStatus(201);

    $this->assertDatabaseHas('allergies', [
      'name' => $allergy['name'],
    ]);
  }

  /** @test */
  public function can_update_allergy()
  {
    $school = School::factory()->create();

    $allergyType = AllergyType::factory()->create();

    $allergy = Allergy::factory()->create();

    $allergy->school = $school->only("id", "name");

    $allergy->allergy_type = $allergyType->only("id", "name");

    // Clone the $allergy instance for the update
    $updatedAllergy = clone $allergy;

    $updatedAllergy->name = $this->faker->name();

    $response = $this->put(route('api.education.allergies.update', $allergy->id), $updatedAllergy->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('allergies', [
        'id' => $allergy->id,
        'name' => $updatedAllergy->name,
    ]);
  }

  /** @test */
  public function can_delete_allergy()
  {
    $allergy = Allergy::factory()->create();

    $response = $this->delete(route('api.education.allergies.destroy', $allergy->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('allergies', [
      'id' => $allergy->id
    ]);
  }

  /** @test */
  public function can_show_allergy()
  {
    $allergy = Allergy::factory()->create();

    $response = $this->get(route('api.education.allergies.show', $allergy->id));

    $response->assertStatus(200);

    $this->assertEquals($allergy->name, $response->json('data.name'));
  }
}
