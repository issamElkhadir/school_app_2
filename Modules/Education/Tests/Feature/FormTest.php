<?php

namespace Modules\Education\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\Form;
use Modules\Education\Entities\FormQuestion;
use Modules\Education\Entities\FormSection;

class FormTest extends TestCase

{
    use WithFaker , RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpUser(['education.form.*' , 'education.form-question.*' ,'education.form-section.*']);
    }
   /** @test */
    public function it_can_create_form_with_sections_and_questions()
    {
        $form = Form::factory()->create()->toArray();

        $sections = FormSection::factory()->count(5)->create([
            'form_id' => $form['id']
        ])->toArray();

        foreach ($sections as $key => $section) {
            $questions = [];
            for ($i = 1; $i <= 2; $i++) {
                $question = FormQuestion::factory()->create([
                    'section_id' => $section['id'] 
                ]);
                $questions[] = $question->toArray();
            }
            $sections[$key]['questions'] = $questions;
        }        
        
        $uniqueSlug = $form['slug'] . '-' . uniqid();
        $form['slug'] = $uniqueSlug;
        $form['sections'] = $sections ; 
        $response = $this->post(route('api.education.forms.store') , $form);

        // dd($response->json());
        
        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['sections' => [ '*' => ['questions']]]]);
        $this->assertDatabaseHas('forms' , [
            'id' => $form['id']
        ]);
    }


    /** @test **/
    public function it_can_update_form_with_sections_and_questions ()
    {
        $form = Form::factory()->create()->toArray();

        $sections = FormSection::factory()->count(5)->create([
            'form_id' => $form['id']
        ])->toArray();

        foreach ($sections as $key => $section) {
            $questions = [];
            for ($i = 1; $i <= 2; $i++) {
                $question = FormQuestion::factory()->create([
                    'section_id' => $section['id'] 
                ]);
                $questions[] = $question->toArray();
            }
            $sections[$key]['questions'] = $questions;
        }        
        
        $uniqueSlug = $form['slug'] . '-' . uniqid();
        $form['slug'] = $uniqueSlug;
        $form['sections'] = $sections ; 
        $response = $this->put(route('api.education.forms.update', $form['id']), $form);

        $response->assertOk()
                ->assertSuccessful()
                ->assertJsonStructure(['data' => ['sections' => [ '*' => ['questions']]]]);
    }


    /** @test **/
    public function it_can_show_form_with_sections_and_questions (){
        $form = Form::factory()->create();

        $sections = FormSection::factory()->count(5)->create([
            'form_id' => $form['id']
        ])->toArray();

        foreach ($sections as $section) {
            for ($i = 1; $i <= 2; $i++) {
                FormQuestion::factory()->create([
                    'section_id' => $section['id']
                ]);
            }
        }
        $uniqueSlug = $form['slug'] . '-' . uniqid();
        $form['slug'] = $uniqueSlug;



        $response =$this->get(route('api.education.forms.show' , $form->id));
        $response->assertOk()
        ->assertJsonStructure(['data' => ['sections' => [ '*' => ['questions']]]]);

        
        $this->assertEquals($form->id , $response->json('data.id'));
    }

    /** @test **/
    public function it_can_delete_form_with_sections_and_questions ()
    {
        $form = Form::factory()->create();

        $sections = FormSection::factory()->count(2)->create([
            'form_id' => $form['id']
        ])->toArray();

        foreach ($sections as $section) {
            for ($i = 1; $i <= 2; $i++) {
                FormQuestion::factory()->create([
                    'section_id' => $section['id']
                ]);
            }
        }
        $response = $this->delete(route('api.education.forms.destroy' , $form->id));

        $response->assertSuccessful();

        $this->assertDatabaseMissing('forms' , [
            'id' => $form->id   
        ]);
    }
}
