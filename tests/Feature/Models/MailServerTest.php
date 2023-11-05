<?php

namespace Tests\Feature\Models;

use App\Models\MailServer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MailServerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['base.mail-server.*']);
  }

  /** @test */
  public function it_can_create_a_mail_server()
  {
    $payload = MailServer::factory()->make()->makeVisible('password')->toArray();

    $response = $this->postJson(route('api.mail-servers.store'), $payload);

    $response->assertStatus(201)
      ->assertJson(['data' => ['name' => $payload['name']]]);

    $this->assertDatabaseHas('mail_servers', ['name' => $payload['name']]);
  }

  /** @test */
  public function it_can_update_a_mail_server()
  {
    $mailServer = MailServer::factory()->create();

    $payload = MailServer::factory()->make()->makeVisible('password')->toArray();

    $response = $this->putJson(route('api.mail-servers.update', $mailServer), $payload);

    $response->assertStatus(200)
      ->assertJson(['data' => ['name' => $payload['name']]]);

    $this->assertDatabaseHas('mail_servers', ['name' => $payload['name']]);
  }

  /** @test */
  public function it_can_delete_a_mail_server()
  {
    $mailServer = MailServer::factory()->create();

    $response = $this->deleteJson(route('api.mail-servers.destroy', $mailServer));

    $response->assertStatus(204);

    $this->assertDatabaseMissing('mail_servers', ['id' => $mailServer->id]);
  }

  /** @test */
  public function it_can_list_mail_servers()
  {
    MailServer::factory()->count(5)->create();

    $response = $this->getJson(route('api.mail-servers.index'));

    $response->assertStatus(200)
      ->assertJsonCount(5, 'data');
  }

  /** @test */
  public function it_can_get_a_mail_server_by_id()
  {
    $mailServer = MailServer::factory()->create();

    $response = $this->getJson(route('api.mail-servers.show', $mailServer->id));

    $response->assertStatus(200);

    $response->assertJson(['data' => ['name' => $mailServer->name]]);
  }
}
