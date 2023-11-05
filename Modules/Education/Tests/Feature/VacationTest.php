<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\Vacation;
use Modules\Education\Entities\VacationType;
use Modules\Education\Entities\Staff;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VacationTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.vacation.*']);
  }

  /** @test * */
  public function can_get_vacation()
  {
    $vacation = Vacation::factory()->count(5);

    $staff = Staff::factory()->create();
    $vacation_type = VacationType::factory()->create();

    $vacation->create([
      'staff_id' => $staff->id,
      'vacation_type_id' => $vacation_type->id,
    ]);

    $response = $this->get(route('api.education.vacations.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test * */
  public function can_create_vacation()
  {
    $vacation = Vacation::factory()->makeOne()->toArray();

    $staff = Staff::factory()->create();
    $vacation_types = VacationType::factory()->create();

    $vacation['staff'] = $staff->only(['id', 'name']);
    $vacation['vacation_type'] = $vacation_types->only(['id', 'name']);

    $response = $this->post(route('api.education.vacations.store'), $vacation);

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'staff']])
      ->assertStatus(201);
  }

  /** @test * */
  public function can_update_vacation()
  {
    $staff = Staff::factory()->create();
    $vacationType = VacationType::factory()->create();

    $vacation = Vacation::factory()->create([
      'staff_id' => $staff->id,
      'vacation_type_id' => $vacationType->id,

    ]);

    $vacation['staff'] = $staff->only(['id', 'name']);
    $vacation['vacation_type'] = $vacationType->only(['id', 'name']);

    $response = $this->put(route('api.education.vacations.update', $vacation->id), $vacation->toArray());

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'staff']])
      ->assertStatus(200);
  }


  /** @test * */
  public function can_show_vacation()
  {
    $vacation = Vacation::factory()->create();

    $response = $this->get(route('api.education.vacations.show', $vacation->id));

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'staff']])
      ->assertStatus(200);

    $this->assertEquals($vacation->id, $response->json('data.id'));

  }

  /** @test * */
  public function can_delete_vacation()
  {
    $vacation = Vacation::factory()->create();

    $response = $this->delete(route('api.education.vacations.destroy', $vacation->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('vacations', [
      'id' => $vacation->id
    ]);
  }
}
