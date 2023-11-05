<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\Clazz;
use Modules\Education\Entities\Level;
use Modules\Education\Entities\Subject;
use App\Models\School;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.class.*']);
  }

  /** @test */
  public function can_get_classes()
  {
    $class = Clazz::factory()->count(5);

    $school = School::factory()->create();
    $level = Level::factory()->create();

    $class->create([
      'school_id' => $school->id,
      'level_id' => $level->id,
    ]);

    $response = $this->get(route('api.education.classes.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_classroom()
  {
    $class = Clazz::factory()->makeOne()->toArray();

    $school = School::factory()->create();

    $level = Level::factory()->create();

    $class['school'] = $school->only('id', 'name');

    $class['level'] = $level->only('id', 'name');

    $subjects = Subject::factory()->count(4)->create();

    $class['subjects'] = $subjects->map->only(['id'])->toArray();

    $response = $this->post(route('api.education.classes.store'), $class);

    $response->assertStatus(201);

    $this->assertDatabaseHas('classes', [
      'name' => $class['name'],
    ]);
  }

  /** @test */
  public function can_update_class()
  {
    $school = School::factory()->create();

    $level = Level::factory()->create();

    $class = Clazz::factory()->create([
      'school_id' => $school->id,
      'level_id' => $level->id,
    ]);

    $class->school = $school->only('id', 'name');

    $class->level = $level->only('id', 'name');

    $subjects = Subject::factory()->count(5)->create();

    $class['subjects'] = $subjects->map->only(['id'])->toArray();

    $class->name = $this->faker->name();

    $response = $this->put(route('api.education.classes.update', $class->id), $class->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('classes', [
      'name' => $class->name
    ]);
  }

  /** @test */
  public function can_delete_class()
  {
    $school = School::factory()->create();

    $level = Level::factory()->create();

    $class = Clazz::factory()->create([
      'school_id' => $school->id,
      'level_id' => $level->id,
    ]);

    $response = $this->delete(route('api.education.classes.destroy', $class->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('classes', [
      'id' => $class->id
    ]);
  }

  /** @test */
  public function can_show_class()
  {
    $school = School::factory()->create();

    $level = Level::factory()->create();

    $class = Clazz::factory()->create([
      'school_id' => $school->id,
      'level_id' => $level->id,
    ]);

    $response = $this->get(route('api.education.classes.show', $class->id));

    $response->assertStatus(200);

    $this->assertEquals($class->name, $response->json('data.name'));
  }
}
