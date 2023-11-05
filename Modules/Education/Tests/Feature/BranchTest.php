<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Cycle;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.branch.*']);
  }

  /** @test */
  public function can_get_branches()
  {
    $branch = Branch::factory()->count(5);

    $cycle = Cycle::factory()->create();
    $branch->create([
      'cycle_id' => $cycle->id,
    ]);

    $response = $this->get(route('api.education.branches.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_branch()
  {
    $branch = Branch::factory()->makeOne()->toArray();

    $cycle = Cycle::factory()->create();

    $branch['cycle'] = ['id'=> $cycle->id, 'name' => $cycle->name];

    $response = $this->post(route('api.education.branches.store'), $branch);

    $response->assertStatus(201);

    $this->assertDatabaseHas('branches', [
      'name' => $branch['name'],
    ]);
  }

  /** @test */
  public function can_update_branch()
  {
    $cycle = Cycle::factory()->create();

    $branch = Branch::factory()->create([
      'cycle_id' => $cycle->id,
    ]);

    $branch->cycle = $cycle->only('id', 'name');


    $branch->name = $this->faker->name();

    $response = $this->put(route('api.education.branches.update', $branch->id), $branch->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('branches', [
      'name' => $branch->name
    ]);
  }

  /** @test */
  public function can_delete_branch()
  {
    $cycle = Cycle::factory()->create();

    $branch = Branch::factory()->create([
      'cycle_id' => $cycle->id,
    ]);

    $response = $this->delete(route('api.education.branches.destroy', $branch->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('branches', [
      'id' => $branch->id
    ]);
  }

  /** @test */
  public function can_show_branch()
  {
    $cycle = Cycle::factory()->create();

    $branch = Branch::factory()->create([
      'cycle_id' => $cycle->id,
    ]);

    $response = $this->get(route('api.education.branches.show', $branch->id));

    $response->assertStatus(200);

    $this->assertEquals($branch->name, $response->json('data.name'));
  }
}
