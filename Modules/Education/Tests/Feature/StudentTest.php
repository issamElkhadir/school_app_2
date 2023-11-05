<?php

namespace Modules\Education\Tests\Feature;

use App\Models\City;
use App\Models\Country;
use App\Models\Language;
use Modules\Education\Entities\Student;
use Modules\Education\Entities\Staff;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.student.*']);
  }

  /** @test */
  public function can_get_students()
  {
    $student = Student::factory()->count(5);

    $country = Country::factory()->create();
    $city = City::factory()->create();
    $language = Language::factory()->create();

    $student->create([
      'contact_country_id' => $country->id,
      'nationality_id' => $country->id,
      'contact_city_id' => $city->id,
      'birth_city_id' => $city->id,
      'native_language' => $language->id,
      'second_language' => $language->id,
    ]);

    $response = $this->get(route('api.education.students.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');
  }

  /** @test */
  public function can_create_student()
  {
    $student = Student::factory()->makeOne()->toArray();

    $country = Country::factory()->create();
    $city = City::factory()->create();
    $language = Language::factory()->create();


    $student['country'] = $country->only('id', 'name');
    $student['nationality'] = $country->only('id', 'name');

    $student['birthCity'] = $city->only('id', 'name');
    $student['city'] = $city->only('id', 'name');

    $student['nativeLanguage'] = $language->only('id', 'name');
    $student['secondLanguage'] = $language->only('id', 'name');


    $response = $this->post(route('api.education.students.store'), $student);

    $response->assertStatus(201);

    //    $this->assertDatabaseHas('students', [
    //      'first_name' => $student['first_name']
    //    ]);
  }

  /** @test */
  public function can_update_student()
  {

    $country = Country::factory()->create();
    $city = City::factory()->create();
    $language = Language::factory()->create();

    $student = Student::factory()->create([
      'contact_country_id' => $country->id,
      'contact_city_id' => $city->id,
      'birth_city_id' => $city->id,
      'nationality_id' => $country->id,
      'native_language' => $language->id,
      'second_language' => $language->id,
    ]);

    $student->country = $country->only('id', 'name');
    $student->nationality = $country->only('id', 'name');
    $student->birthCity = $city->only('id', 'name');
    $student->city = $city->only('id', 'name');
    $student->nativeLanguage = $language->only('id', 'name');
    $student->secondLanguage = $language->only('id', 'name');

    //    $student->first_name = $this->faker->name();

    $response = $this->put(route('api.education.students.update', $student->id), $student->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('students', [
      'first_name' => $student->first_name
    ]);
  }

  /** @test */
  public function can_delete_student()
  {
    $country = Country::factory()->create();
    $city = City::factory()->create();
    $language = Language::factory()->create();

    $student = Student::factory()->create([
      'contact_country_id' => $country->id,
      'contact_city_id' => $city->id,
      'birth_city_id' => $city->id,
      'nationality_id' => $country->id,
      'native_language' => $language->id,
      'second_language' => $language->id,
    ]);;

    $response = $this->delete(route('api.education.students.destroy', $student->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('students', [
      'id' => $student->id
    ]);
  }

  /** @test */
  public function can_show_student()
  {
    $country = Country::factory()->create();
    $city = City::factory()->create();
    $language = Language::factory()->create();

    $student = Student::factory()->create([
      'contact_country_id' => $country->id,
      'contact_city_id' => $city->id,
      'birth_city_id' => $city->id,
      'nationality_id' => $country->id,
      'native_language' => $language->id,
      'second_language' => $language->id,
    ]);

    $response = $this->get(route('api.education.students.show', $student->id));

    $response->assertStatus(200);

    $this->assertEquals($student->first_name, $response->json('data.first_name'));
  }
}
