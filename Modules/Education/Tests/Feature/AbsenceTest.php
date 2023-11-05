<?php

namespace Modules\Education\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\Absence;
use Modules\Education\Entities\AbsenceType;
use Modules\Education\Entities\Achievement;
use Modules\Education\Entities\Student;
use Modules\Education\Entities\Subscription;

class AbsenceTest extends TestCase
{
    use WithFaker , RefreshDatabase ;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpUser(['education.absence.*']);
    }

    /** @test */
    public function it_can_get_absences()
    {
        $absences = Absence::factory()->count(10);
        $absenceType = AbsenceType::factory()->create();
        $student = Student::factory()->create();
        $achievement = Achievement::factory()->create();
        $subscription = Subscription::factory()->create();

        $absences->create([
            'absence_type_id' => $absenceType->id,
            'student_id' => $student->id,
            'achievement_id' => $achievement->id ,
            'subscription_id' => $subscription->id,
        ]);


        $response = $this->get(route('api.education.absences.index'));

        $response->assertSuccessful()
            ->assertJsonCount(10, 'data')
            ->assertStatus(200);
    }
    /** @test */
    public function it_can_create_absence()
    {
        $absence = Absence::factory()->makeOne()->toArray();
        $absenceType = AbsenceType::factory()->create();
        $student = Student::factory()->create();
        $achievement = Achievement::factory()->create();
        $subscription = Subscription::factory()->create();

        // dd($achievement);

        $absence['absence_type'] = $absenceType->only(['id', 'name']);
        $absence['student'] = $student->only(['id', 'name']);
        $absence['achievement'] = $achievement->only(['id', 'name']);
        $absence['subscription'] = $subscription->only(['id', 'name']);

        // dd($absence);

        $response = $this->post(route('api.education.absences.store'), $absence);

        // dd($response->json());
        $response->assertSuccessful()
            ->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'student', 'absence_type' , 'subscription' , 'achievement']]);
        
    }

    /** @test */

    public function it_can_update_absence()
    {
        $absenceType = AbsenceType::factory()->create();
        $student = Student::factory()->create();
        $achievement = Achievement::factory()->create();
        $subscription = Subscription::factory()->create();

        $absence = Absence::factory()->create([
            'absence_type_id' => $absenceType->id,
            'student_id' => $student->id,
            'achievement_id' => $achievement->id,
            'subscription_id' => $subscription->id,
        ]);


        $absence->absence_type = $absenceType->only(['id', 'name']);
        $absence->student = $student->only(['id', 'name']);
        $absence->achievement = $achievement->only(['id', 'name']);
        $absence->subscription = $subscription->only(['id', 'name']);

        $response = $this->put(route('api.education.absences.update' , $absence->id) , $absence->toArray());

        $response->assertOk()
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['id', 'student', 'absence_type' , 'subscription' , 'achievement']]);
        

        $this->assertDatabaseHas('absences', [
            'absence_type_id' => $absenceType->id,
            'student_id' => $student->id,
            'achievement_id' => $achievement->id,
            'subscription_id' => $subscription->id
        ]);
    }

    /** @test */
    public function it_can_delete_absence()
    {
        $absenceType = AbsenceType::factory()->create();
        $student = Student::factory()->create();
        $achievement = Achievement::factory()->create();
        $subscription = Subscription::factory()->create();

        $absence = Absence::factory()->create([
            'absence_type_id' => $absenceType->id,
            'student_id' => $student->id,
            'achievement_id' => $achievement->id,
            'subscription_id' => $subscription->id,
        ]);

        $response = $this->delete(route('api.education.absences.destroy' , $absence->id));

        $response->assertSuccessful()
            ->assertStatus(200);

        $this->assertDatabaseMissing('absences', [
            'id' => $absence->id
        ]);
    }

    /** @test */

    public function it_can_show_absence ()
    {
        $absenceType = AbsenceType::factory()->create();
        $student = Student::factory()->create();
        $achievement = Achievement::factory()->create();
        $subscription = Subscription::factory()->create();

        $absence = Absence::factory()->create([
            'absence_type_id' => $absenceType->id,
            'student_id' => $student->id,
            'achievement_id' => $achievement->id,
            'subscription_id' => $subscription->id,
        ]);

        $response = $this->get(route('api.education.absences.show' , $absence->id));

        $response->assertSuccessful()
            ->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'student', 'absence_type' , 'subscription' , 'achievement']]);
        
        $this->assertEquals($absence->id, $response->json('data.id'));
    }
}
