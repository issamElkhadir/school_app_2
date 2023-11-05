<?php

namespace Modules\Education\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\FormQuestion;
use Modules\Education\Entities\FormSection;

class FormQuestionTest extends TestCase
{
    use WithFaker , RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpUser(['education.form-question.*']);
    }
    /** @test */
    public function it_can_get_form_questions()
    {
        $formQuestions = FormQuestion::factory()->count(10);
        $section = FormSection::factory()->create();

        $formQuestions->create([
            'section_id' => $section->id
        ]);

        $response = $this->get(route('api.education.form-questions.index'));
        $response->assertOk()
                ->assertSuccessful()
                ->assertJsonCount(10 , 'data');
    }

    /** @test */
    public function  it_can_create_form_question(){
        $section = FormSection::factory()->create();
        $formQuestion = FormQuestion::factory()->makeOne()->toArray();

        $formQuestion['section'] = $section->only(['id' , 'slug']);
        $response = $this->post(route('api.education.form-questions.store') , $formQuestion);

        // dump($response->json());
        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id' ,'section']]);
    }

    /** @test */

    public function it_can_update_form_question()
    {
        $section = FormSection::factory()->create();
        $formQuestion = FormQuestion::factory()->create([
            'section_id' => $section->id
        ]);

        $formQuestion->section = $section->only(['id' , 'slug']);
        $response = $this->put(route('api.education.form-questions.update' , $formQuestion->id) , $formQuestion->toArray());

        $response->assertOk()
                ->assertJsonStructure(['data' => ['id' , 'section']]);
        $this->assertDatabaseHas('form_questions' , [
            'id' => $formQuestion->id
        ]);
    }
/** @test */
    public function it_can_show_form_question ()
    {
        $formQuestion = FormQuestion::factory()->create();

        $response = $this->get(route('api.education.form-questions.show',$formQuestion->id));

        $response->assertOk();

        $this->assertEquals($formQuestion->id , $response->json('data.id'));
    }

    /** @test */
    public function it_can_delete_form_question() 
    {
        $formQuestion = FormQuestion::factory()->create();

        $response = $this->delete(route('api.education.form-questions.destroy',$formQuestion->id));

        $response->assertOk();

        $this->assertDatabaseMissing('form_questions' , [
            'id' => $formQuestion->id
        ]);
    }
}
