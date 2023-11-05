<?php

namespace Modules\Education\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\FormAnswer;
use Modules\Education\Entities\FormQuestion;
use Modules\Education\Entities\FormSection;
use Modules\Education\Entities\Participator;

class FormAnswerTest extends TestCase
{
    use WithFaker , RefreshDatabase ;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpUser(['education.form-answer.*']);
    }

    /** @test */
    public function it_can_get_form_answers ()
    {
        $formAnswers = FormAnswer::factory()->count(10);
        $question = FormQuestion::factory()->create();
        $participator = Participator::factory()->create();
        $section = FormSection::factory()->create();

        $formAnswers->create([
            'question_id' => $question->id ,
            'participator_id' => $participator->id,
            'section_id' => $section->id,
        ]);

        $response = $this->get(route('api.education.form-answers.index'));

        $response->assertOk()
                ->assertJsonCount(10 , 'data');
    }

    /** @test */
    public function it_can_create_form_answers ()
    {
        $formAnswer = FormAnswer::factory()->makeOne()->toArray();
        $question = FormQuestion::factory()->create();
        $participator = Participator::factory()->create();
        $section = FormSection::factory()->create();

        $formAnswer['question'] = $question->only('id') ;
        $formAnswer['participator'] = $participator->only('id');
        $formAnswer['section'] = $section->only('id');

        $response = $this->post(route('api.education.form-answers.store') , $formAnswer);


        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id','question' , 'participator']]);

    }

    /** @test */

    public function it_can_update_form_answer ()
    {
        $question = FormQuestion::factory()->create();
        $participator = Participator::factory()->create();
        $formAnswer = FormAnswer::factory()->create();
        $section = FormSection::factory()->create();

        $formAnswer->question = $question->only('id');
        $formAnswer->participator = $participator->only('id');
        $formAnswer->section = $section->only('id');

        $response = $this->put(route('api.education.form-answers.update' , $formAnswer->id) , $formAnswer->toArray());

        $response->assertOk()
                ->assertJsonStructure(['data' => ['id' , 'question' , 'participator']]);

        $this->assertDatabaseHas('form_answers' , [
            'id' => $formAnswer->id
        ]);
    }

    /** @test */
    public function it_can_show_form_answer ()
    {
        $question = FormQuestion::factory()->create();
        $participator = Participator::factory()->create();
        $formAnswer = FormAnswer::factory()->create();
        $section = FormSection::factory()->create();

        $formAnswer->question = $question->only('id');
        $formAnswer->participator = $participator->only('id');
        $formAnswer->section = $section->only('id');

        $response = $this->get(route('api.education.form-answers.show' , $formAnswer->id));

        $response->assertOk()
                ->assertJsonStructure(['data' => ['id' , 'question' , 'participator']]);
        
        $this->assertEquals($formAnswer->id, $response->json('data.id'));
    }

    /** @test */

    public function it_can_delete_form_answer ()
    {
        $question = FormQuestion::factory()->create();
        $participator = Participator::factory()->create();
        $formAnswer = FormAnswer::factory()->create();
        $section = FormSection::factory()->create();

        $formAnswer->question = $question->only('id');
        $formAnswer->participator = $participator->only('id');
        $formAnswer->section = $section->only('id');

        $response = $this->delete(route('api.education.form-answers.destroy' , $formAnswer->id));

        $response->assertOk();
        
        $this->assertDatabaseMissing('form_answers' , [
            'id' => $formAnswer->id
        ]);
    }
}
