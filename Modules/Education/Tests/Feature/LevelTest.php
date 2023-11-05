<?php

namespace Modules\Education\Tests\Feature;

use App\Models\City;
use Modules\Education\Entities\Level;
use Modules\Education\Entities\Branch;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LevelTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.level.*']);
  }

  /** @test */
  public function can_get_levels()
  {
    $level = Level::factory()->count(5);

    $branch = Branch::factory()->create();
    $level->create([
      'branch_id' => $branch->id,
    ]);

    $response = $this->get(route('api.education.levels.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_level()
  {
    $level = Level::factory()->makeOne()->toArray();

    $branch = Branch::factory()->create();

    $level['branch'] = $branch->only('id', 'name');

    $response = $this->post(route('api.education.levels.store'), $level);

    $response->assertStatus(201);

    $this->assertDatabaseHas('levels', [
      'name' => $level['name'],
    ]);
  }

  /** @test */
  public function can_update_level()
  {
    $branch = Branch::factory()->create();

    $level = Level::factory()->create([
      'branch_id' => $branch->id,
    ]);

    $level->branch = $branch->only('id', 'name');


    $level->name = $this->faker->name();

    $response = $this->put(route('api.education.levels.update', $level->id), $level->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('levels', [
      'name' => $level->name
    ]);
  }

  /** @test */
  public function can_delete_level()
  {
    $branch = Branch::factory()->create();

    $level = Level::factory()->create([
      'branch_id' => $branch->id,
    ]);

    $response = $this->delete(route('api.education.levels.destroy', $level->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('levels', [
      'id' => $level->id
    ]);
  }

  /** @test */
  public function can_show_level()
  {
    $branch = Branch::factory()->create();

    $level = Level::factory()->create([
      'branch_id' => $branch->id,
    ]);

    $response = $this->get(route('api.education.levels.show', $level->id));

    $response->assertStatus(200);

    $this->assertEquals($level->name, $response->json('data.name'));
  }
}
