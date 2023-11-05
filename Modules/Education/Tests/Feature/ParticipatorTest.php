<?php

namespace Modules\Education\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\Form;
use Modules\Education\Entities\Participator;
use Modules\Education\Entities\Student;

class ParticipatorTest extends TestCase
{
    use WithFaker , RefreshDatabase ;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpUser(['education.participator.*']);
    }

    /** @test */
    public function it_can_get_participators ()
    {
        $participators = Participator::factory()->count(10);
        $student = Student::factory()->create();
        $form = Form::factory()->create();

        $participators->create([
            'form_id' => $form->id ,
            'student_id' => $student->id
        ]);

        $response = $this->get(route('api.education.participators.index'));

        $response->assertOk()
                ->assertJsonCount(10 , 'data');
    }

    /** @test */
    public function it_can_create_participator ()
    {
        $participator = Participator::factory()->makeOne()->toArray();
        $student = Student::factory()->create();
        $form = Form::factory()->create();

        $participator['form'] = $form->only('id') ;
        $participator['student'] = $student->only('id');

        $response = $this->post(route('api.education.participators.store') , $participator);


        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id','student' , 'form']]);

    }

    /** @test */

    public function it_can_update_participator ()
    {
        $student = Student::factory()->create();
        $form = Form::factory()->create();
        $participator = Participator::factory()->create();

        $participator->student = $student->only('id');
        $participator->form = $form->only('id');

        $response = $this->put(route('api.education.participators.update' , $participator->id) , $participator->toArray());

        $response->assertOk()
                ->assertJsonStructure(['data' => ['id' , 'student' , 'form']]);

        $this->assertDatabaseHas('participators' , [
            'id' => $participator->id
        ]);
    }

    /** @test */
    public function it_can_show_participator ()
    {
        $student = Student::factory()->create();
        $form = Form::factory()->create();
        $participator = Participator::factory()->create();

        $participator->student = $student->only('id');
        $participator->form = $form->only('id');

        $response = $this->get(route('api.education.participators.show' , $participator->id));

        $response->assertOk()
                ->assertJsonStructure(['data' => ['id' , 'student' , 'form']]);
        
        $this->assertEquals($participator->id, $response->json('data.id'));
    }

    /** @test */

    public function it_can_delete_participator ()
    {
        $student = Student::factory()->create();
        $form = Form::factory()->create();
        $participator = Participator::factory()->create();

        $participator->student = $student->only('id');
        $participator->form = $form->only('id');

        $response = $this->delete(route('api.education.participators.destroy' , $participator->id));

        $response->assertOk();
        
        $this->assertDatabaseMissing('participators' , [
            'id' => $participator->id
        ]);
    }
}
