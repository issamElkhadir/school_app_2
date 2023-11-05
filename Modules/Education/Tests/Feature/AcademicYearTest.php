<?php

namespace Modules\Education\Tests\Feature;

use App\Models\City;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\AcademicYear;
use Modules\Education\Entities\SubjectSequence;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AcademicYearTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.academic-year.*']);
  }

  /** @test */
  public function can_get_academic_years()
  {
    $academicYear = AcademicYear::factory()->count(5);

    $parentAcademicYear = AcademicYear::factory()->create();
    $academicYear->create([
      'parent_academic_year_id' => $parentAcademicYear->id,
    ]);

    $response = $this->get(route('api.education.academic-years.index'));

    $response->assertSuccessful()
      ->assertJsonCount(6, 'data');

  }

  /** @test */
  public function can_create_academic_year()
  {
    $academicYear = AcademicYear::factory()->makeOne()->toArray();

    $parentAcademicYear = AcademicYear::factory()->create();

    $academicYear['subject'] = $parentAcademicYear->only('id', 'name');

    $response = $this->post(route('api.education.academic-years.store'), $academicYear);

    $response->assertStatus(201);

    $this->assertDatabaseHas('academic_years', [
      'name' => $academicYear['name'],
    ]);
  }

  /** @test */
  public function can_update_academic_year()
  {
    $parentAcademicYear = AcademicYear::factory()->create();

    $academicYear = AcademicYear::factory()->create([
      'parent_academic_year_id' => $parentAcademicYear->id,
    ]);

    $academicYear->subject = $parentAcademicYear->only('id', 'name');


    $academicYear->name = $this->faker->text();

    $response = $this->put(route('api.education.academic-years.update', $academicYear->id), $academicYear->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('academic_years', [
      'name' => $academicYear->name
    ]);
  }

  /** @test */
  public function can_delete_academic_year()
  {
    $parentAcademicYear = AcademicYear::factory()->create();

    $academicYear = AcademicYear::factory()->create([
      'parent_academic_year_id' => $parentAcademicYear->id,
    ]);

    $response = $this->delete(route('api.education.academic-years.destroy', $academicYear->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('academic_years', [
      'id' => $academicYear->id
    ]);
  }

  /** @test */
  public function can_show_academic_year()
  {
    $parentAcademicYear = AcademicYear::factory()->create();

    $academicYear = AcademicYear::factory()->create([
      'parent_academic_year_id' => $parentAcademicYear->id,
    ]);

    $response = $this->get(route('api.education.academic-years.show', $academicYear->id));

    $response->assertStatus(200);

    $this->assertEquals($academicYear->name, $response->json('data.name'));
  }
}
