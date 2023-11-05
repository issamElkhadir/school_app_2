<?php

namespace Modules\Education\Tests\Feature;

use App\Models\City;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Subject;
use Modules\Education\Entities\SubjectSequence;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectSequenceTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.subject-sequence.*']);
  }

  /** @test */
  public function can_get_subject_sequences()
  {
    $subjectSequence = SubjectSequence::factory()->count(5);

    $subject = Subject::factory()->create();
    $subjectSequence->create([
      'subject_id' => $subject->id,
    ]);

    $response = $this->get(route('api.education.subject-sequences.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_subject_sequence()
  {
    $subjectSequence = SubjectSequence::factory()->makeOne()->toArray();

    $subject = Subject::factory()->create();

    $subjectSequence['subject'] = $subject->only('id', 'name');

    $response = $this->post(route('api.education.subject-sequences.store'), $subjectSequence);

    $response->assertStatus(201);

    $this->assertDatabaseHas('subject_sequences', [
      'content' => $subjectSequence['content'],
    ]);
  }

  /** @test */
  public function can_update_subject_sequence()
  {
    $subject = Subject::factory()->create();

    $subjectSequence = SubjectSequence::factory()->create([
      'subject_id' => $subject->id,
    ]);

    $subjectSequence->subject = $subject->only('id', 'name');


    $subjectSequence->content = $this->faker->text();

    $response = $this->put(route('api.education.subject-sequences.update', $subjectSequence->id), $subjectSequence->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('subject_sequences', [
      'content' => $subjectSequence->content
    ]);
  }

  /** @test */
  public function can_delete_subject_sequence()
  {
    $subject = Subject::factory()->create();

    $subjectSequence = SubjectSequence::factory()->create([
      'subject_id' => $subject->id,
    ]);

    $response = $this->delete(route('api.education.subject-sequences.destroy', $subjectSequence->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('subject_sequences', [
      'id' => $subjectSequence->id
    ]);
  }

  /** @test */
  public function can_show_subject_sequence()
  {
    $subject = Subject::factory()->create();

    $subjectSequence = SubjectSequence::factory()->create([
      'subject_id' => $subject->id,
    ]);

    $response = $this->get(route('api.education.subject-sequences.show', $subjectSequence->id));

    $response->assertStatus(200);

    $this->assertEquals($subjectSequence->content, $response->json('data.content'));
  }
}
