<?php

namespace Modules\Education\Tests\Feature;

use App\Models\School;
use Modules\Education\Entities\Staff;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StaffTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.staff.*']);
  }

  /** @test */
  public function can_get_staff()
  {
    Staff::factory()->count(5)->create();

    $response = $this->get(route('api.education.staff.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');
  }

  /** @test */
  public function can_create_staff()
  {
    $staff = Staff::factory()->makeOne()->toArray();

    $schools = School::factory()->count(5)->create();

    $staff['schools'] = $schools->map->only(['id'])->toArray();

    $response = $this->post(route('api.education.staff.store'), $staff);

    $response->assertStatus(201);

    $this->assertDatabaseHas('staff', [
      'name' => $staff['name']
    ]);
  }

  /** @test */
  public function can_update_staff()
  {

    $staff = Staff::factory()->create();

    $schools = School::factory()->count(5)->create();

    $staff['schools'] = $schools->map->only(['id'])->toArray();

    $staff->name = $this->faker->name();

    $response = $this->put(route('api.education.staff.update', $staff->id), $staff->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('staff', [
      'name' => $staff->name
    ]);
  }

  /** @test */
  public function can_delete_staff()
  {
    $staff = Staff::factory()->create();

    $response = $this->delete(route('api.education.staff.destroy', $staff->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('staff', [
      'id' => $staff->id
    ]);
  }

  /** @test */
  public function can_show_staff()
  {
    $staff = Staff::factory()->create();

    $response = $this->get(route('api.education.staff.show', $staff->id));

    $response->assertStatus(200);

    $this->assertEquals($staff->name, $response->json('data.name'));
  }
}
