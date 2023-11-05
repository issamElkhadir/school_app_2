<?php

namespace Modules\Education\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\Form;
use Modules\Education\Entities\FormSection;

class FormSectionTest extends TestCase
{
    use WithFaker , RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpUser(['education.form-section.*']);
    }

    /** @test */
    public function it_can_get_form_sections()
    {
        $formsSection = FormSection::factory()->count(10);
        $form = Form::factory()->create();

        $formsSection->create([
            'form_id' => $form->id
        ]);

        $response = $this->get(route('api.education.form-sections.index'));
        $response->assertOk()
                ->assertSuccessful()
                ->assertJsonCount(10 , 'data');
    }

    /** @test */
    public function  it_can_create_form_section(){
        $form = Form::factory()->create();
        $formSection = FormSection::factory()->makeOne()->toArray();

        $formSection['form'] = $form->only(['id' , 'name']);

        $response = $this->post(route('api.education.form-sections.store') , $formSection);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id' ,'form']]);
        
    }

    /** @test */

    public function it_can_update_form_section()
    {
        $form = Form::factory()->create();
        $formSection = FormSection::factory()->create([
            'form_id' => $form
        ]);

        $formSection->form = $form->only(['id' , 'name']);


        $response = $this->put(route('api.education.form-sections.update' , $formSection->id) , $formSection->toArray());

        $response->assertOk()
                ->assertJsonStructure(['data' => ['id' , 'form']]);
        $this->assertDatabaseHas('form_sections' , [
            'id' => $formSection->id
        ]);
    }

    /** @test */
    public function it_can_delete_form_section()
    {
        $formSection = FormSection::factory()->create();

        $response = $this->delete(route('api.education.form-sections.destroy',$formSection->id));

        $response->assertOk();

        $this->assertDatabaseMissing('form_sections' , [
            'id' => $formSection->id
        ]);
    }

    /** @test */

    public function it_can_show_form_section ()
    {
        $formSection = FormSection::factory()->create();

        $response = $this->get(route('api.education.form-sections.show',$formSection->id));

        $response->assertOk();

        $this->assertEquals($formSection->id , $response->json('data.id'));
    }
}
