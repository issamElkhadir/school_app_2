<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\ClassroomType;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassroomTypeTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.classroom-type.*']);
  }

  /** @test */
  public function can_get_classroom_types()
  {
    ClassroomType::factory()->count(5)->create();

    $response = $this->get(route('api.education.classroom-types.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_classroom_type()
  {
    $classroomType = ClassroomType::factory()->makeOne()->toArray();

    $response = $this->post(route('api.education.classroom-types.store'), $classroomType);

    $response->assertStatus(201);

    $this->assertDatabaseHas('classroom_types', [
      'name' => $classroomType['name'],
    ]);
  }

  /** @test */
  public function can_update_classroom_type()
  {
    $classroomType = ClassroomType::factory()->create();

    $classroomType->name = $this->faker->name();

    $response = $this->put(route('api.education.classroom-types.update', $classroomType->id), $classroomType->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('classroom_types', [
      'name' => $classroomType->name
    ]);
  }

  /** @test */
  public function can_delete_classroom_type()
  {
    $classroomType = ClassroomType::factory()->create();

    $response = $this->delete(route('api.education.classroom-types.destroy', $classroomType->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('classroom_types', [
      'id' => $classroomType->id
    ]);
  }

  /** @test */
  public function can_show_classroom_type()
  {
    $classroomType = ClassroomType::factory()->create();

    $response = $this->get(route('api.education.classroom-types.show', $classroomType->id));

    $response->assertStatus(200);

    $this->assertEquals($classroomType->name, $response->json('data.name'));
  }
}
