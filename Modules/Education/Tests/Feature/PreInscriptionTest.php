<?php

namespace Modules\Education\Tests\Feature;

use App\Models\School;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\Form;
use Modules\Education\Entities\Level;
use Modules\Education\Entities\PreInscription;

class PreInscriptionTest extends TestCase
{
    use WithFaker , RefreshDatabase ;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpUser(['education.pre-inscription.*']);
    }

    /** @test */
    public function it_can_get_pre_inscriptions ()
    {
        $preInscriptions = PreInscription::factory()->count(10);
        $school = School::factory()->create();
        $form = Form::factory()->create();
        $level = Level::factory()->create();

        $preInscriptions->create([
            'form_id' => $form->id ,
            'school_id' => $school->id ,
            'level_id' => $level->id
        ]);

        $response = $this->get(route('api.education.pre-inscriptions.index'));

        $response->assertOk()
                ->assertJsonCount(10 , 'data');
    }

    /** @test */
    /** @test */
    public function it_can_create_pre_inscription ()
    {
        $preInscription = PreInscription::factory()->makeOne()->toArray();
        $school = School::factory()->create();
        $form = Form::factory()->create();
        $level = Level::factory()->create();

        $preInscription['form'] = $form->only('id') ;
        $preInscription['school'] = $school->only('id');
        $preInscription['level'] = $level->only('id');

        $response = $this->post(route('api.education.pre-inscriptions.store') , $preInscription);


        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id','school' , 'form' , 'level']]);

    }

    /** @test */

    public function it_can_update_pre_inscription  ()
    {
        $school = School::factory()->create();
        $form = Form::factory()->create();
        $level = Level::factory()->create();
        $preInscription = PreInscription::factory()->create();

        $preInscription->school = $school->only('id');
        $preInscription->form = $form->only('id');
        $preInscription->level = $level->only('id');

        $response = $this->put(route('api.education.pre-inscriptions.update' , $preInscription->id) , $preInscription->toArray());

        $response->assertOk()
                ->assertJsonStructure(['data' => ['id' , 'school' ,'level', 'form']]);

        $this->assertDatabaseHas('pre_inscriptions' , [
            'id' => $preInscription->id
        ]);
    }

    /** @test */
    public function it_can_show_pre_inscription  ()
    {
        $school = School::factory()->create();
        $form = Form::factory()->create();
        $level = Level::factory()->create();
        $preInscription = PreInscription::factory()->create();

        $preInscription->school = $school->only('id');
        $preInscription->form = $form->only('id');
        $preInscription->level = $level->only('id');

        $response = $this->get(route('api.education.pre-inscriptions.show' , $preInscription->id));

        $response->assertOk()
                ->assertJsonStructure(['data' => ['id' , 'school' ,'level','form']]);
        $this->assertEquals($preInscription->id, $response->json('data.id'));
    }

    /** @test */
    public function it_can_delete_pre_inscription ()
    {
        $school = School::factory()->create();
        $form = Form::factory()->create();
        $level = Level::factory()->create();
        $preInscription = PreInscription::factory()->create();

        $preInscription->school = $school->only('id');
        $preInscription->form = $form->only('id');
        $preInscription->level = $level->only('id');

        $response = $this->delete(route('api.education.pre-inscriptions.destroy' , $preInscription->id));

        $response->assertOk();
        
        $this->assertDatabaseMissing('pre_inscriptions' , [
            'id' => $preInscription->id
        ]);
    }

    /** @test */
    public function it_can_get_pre_inscription_by_slug ()
    {
        $school = School::factory()->create();
        $form = Form::factory()->create();
        $level = Level::factory()->create();
        $preInscription = PreInscription::factory()->create();

        $preInscription->school = $school->only('id');
        $preInscription->form = $form->only('id');
        $preInscription->level = $level->only('id');


        $response = $this->get(route('pre-inscription' , $preInscription->slug));

        $response->assertOk();
    }
}
