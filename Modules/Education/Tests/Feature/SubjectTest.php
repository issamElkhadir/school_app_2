<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\ClassroomType;
use Modules\Education\Entities\Period;
use Modules\Education\Entities\Subject;
use Modules\Education\Entities\Unity;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.subject.*']);
  }

  /** @test */
  public function can_get_subjects()
  {
    $subject = Subject::factory()->count(5);

    $unity = Unity::factory()->create();
    $classroomType = ClassroomType::factory()->create();

    $subject->create([
      'unity_id' => $unity->id,
      'classroom_type_id' => $classroomType->id,
    ]);

    $response = $this->get(route('api.education.subjects.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_subject()
  {
    $subject = Subject::factory()->makeOne()->toArray();

    $unity = Unity::factory()->create();

    $classroomType = ClassroomType::factory()->create();

    $subject['unity'] = $unity->only('id', 'name');

    $subject['classroomType'] = $classroomType->only('id', 'name');

    $periods = Period::factory()->count(5)->create();

    $subject['periods'] = $periods->map->only(['id'])->toArray();

    $response = $this->post(route('api.education.subjects.store'), $subject);

    $response->assertStatus(201);

    $this->assertDatabaseHas('subjects', [
      'name' => $subject['name'],
    ]);
  }

  /** @test */
  public function can_update_subject()
  {
    $unity = Unity::factory()->create();

    $classroomType = ClassroomType::factory()->create();

    $subject = Subject::factory()->create([
      'unity_id' => $unity->id,
      'classroom_type_id' => $classroomType->id,
    ]);

    $subject->unity = $unity->only('id', 'name');

    $subject->classroomType = $classroomType->only('id', 'name');

    $periods = Period::factory()->count(5)->create();

    $subject['periods'] = $periods->map->only(['id'])->toArray();

    $subject->name = $this->faker->name();

    $response = $this->put(route('api.education.subjects.update', $subject->id), $subject->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('subjects', [
      'name' => $subject->name
    ]);
  }

  /** @test */
  public function can_delete_subject()
  {
    $unity = Unity::factory()->create();

    $classroomType = ClassroomType::factory()->create();

    $subject = Subject::factory()->create([
      'unity_id' => $unity->id,
      'classroom_type_id' => $classroomType->id,
    ]);

    $response = $this->delete(route('api.education.subjects.destroy', $subject->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('subjects', [
      'id' => $subject->id
    ]);
  }

  /** @test */
  public function can_show_subject()
  {
    $unity = Unity::factory()->create();

    $classroomType = ClassroomType::factory()->create();

    $subject = Subject::factory()->create([
      'unity_id' => $unity->id,
      'classroom_type_id' => $classroomType->id,
    ]);

    $response = $this->get(route('api.education.subjects.show', $subject->id));

    $response->assertStatus(200);

    $this->assertEquals($subject->name, $response->json('data.name'));
  }
}
