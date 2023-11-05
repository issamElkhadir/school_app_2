<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\Classroom;
use Modules\Education\Entities\ClassroomType;
use App\Models\School;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassroomTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.classroom.*']);
  }

  /** @test */
  public function can_get_classrooms()
  {
    $classroom = Classroom::factory()->count(5);

    $school = School::factory()->create();
    $classroomType = ClassroomType::factory()->create();

    $classroom->create([
      'school_id' => $school->id,
      'classroom_type_id' => $classroomType->id,
    ]);

    $response = $this->get(route('api.education.classrooms.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_classroom()
  {
    $classroom = Classroom::factory()->makeOne()->toArray();

    $school = School::factory()->create();

    $classroomType = ClassroomType::factory()->create();

    $classroom['school'] = $school->only('id', 'name');

    $classroom['classroomType'] = $classroomType->only('id', 'name');

    $response = $this->post(route('api.education.classrooms.store'), $classroom);

    $response->assertStatus(201);

    $this->assertDatabaseHas('classrooms', [
      'name' => $classroom['name'],
    ]);
  }

  /** @test */
  public function can_update_classroom()
  {
    $school = School::factory()->create();

    $classroomType = ClassroomType::factory()->create();

    $classroom = Classroom::factory()->create([
      'school_id' => $school->id,
      'classroom_type_id' => $classroomType->id,
    ]);

    $classroom->school = $school->only('id', 'name');

    $classroom->classroomType = $classroomType->only('id', 'name');

    $classroom->name = $this->faker->name();

    $response = $this->put(route('api.education.classrooms.update', $classroom->id), $classroom->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('classrooms', [
      'name' => $classroom->name
    ]);
  }

  /** @test */
  public function can_delete_classroom()
  {
    $school = School::factory()->create();

    $classroomType = ClassroomType::factory()->create();

    $classroom = Classroom::factory()->create([
      'school_id' => $school->id,
      'classroom_type_id' => $classroomType->id,
    ]);

    $response = $this->delete(route('api.education.classrooms.destroy', $classroom->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('classrooms', [
      'id' => $classroom->id
    ]);
  }

  /** @test */
  public function can_show_classroom()
  {
    $school = School::factory()->create();

    $classroomType = ClassroomType::factory()->create();

    $classroom = Classroom::factory()->create([
      'school_id' => $school->id,
      'classroom_type_id' => $classroomType->id,
    ]);

    $response = $this->get(route('api.education.classrooms.show', $classroom->id));

    $response->assertStatus(200);

    $this->assertEquals($classroom->name, $response->json('data.name'));
  }
}
