<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\Sanction;
use Modules\Education\Entities\SanctionType;
use Modules\Education\Entities\Staff;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SanctionTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.sanction.*']);
  }

  /** @test * */
  public function can_get_sanctions()
  {
    $sanctions = Sanction::factory()->count(5);

    $staff = Staff::factory()->create();
    $sanctionType = SanctionType::factory()->create();

    $sanctions->create([
      'staff_id' => $staff->id,
      'sanction_type_id' => $sanctionType->id,
    ]);

    $response = $this->get(route('api.education.sanctions.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test * */
  public function can_create_sanction()
  {
    $sanction = Sanction::factory()->makeOne()->toArray();

    $staff = Staff::factory()->create();
    $sanctionType = SanctionType::factory()->create();

    $sanction['staff'] = $staff->only(['id', 'name']);
    $sanction['sanction_type'] = $sanctionType->only(['id', 'name']);

    $response = $this->post(route('api.education.sanctions.store'), $sanction);

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'staff', 'sanction_type']])
      ->assertStatus(201);
  }

  /** @test * */
  public function can_update_sanction()
  {
    $staff = Staff::factory()->create();
    $sanctionType = SanctionType::factory()->create();

    $sanction = Sanction::factory()->create([
      'staff_id' => $staff->id,
      'sanction_type_id' => $sanctionType->id,

    ]);

    $sanction['staff'] = $staff->only(['id', 'name']);
    $sanction['sanction_type'] = $sanctionType->only(['id', 'name']);


    $response = $this->put(route('api.education.sanctions.update', $sanction->id), $sanction->toArray());

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'staff', 'sanction_type']])
      ->assertStatus(200);
  }


  /** @test * */
  public function can_show_sanction()
  {
   $sanction = Sanction::factory()->create();

    $response = $this->get(route('api.education.sanctions.show', $sanction->id));

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'staff', 'sanction_type']])
      ->assertStatus(200);

    $this->assertEquals($sanction->id, $response->json('data.id'));

  }

  /** @test * */
  public function can_delete_sanction()
  {
    $sanction = Sanction::factory()->create();

    $response = $this->delete(route('api.education.sanctions.destroy', $sanction->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('sanctions', [
      'id' => $sanction->id
    ]);
  }
}
