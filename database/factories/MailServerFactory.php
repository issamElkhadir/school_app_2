<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MailServer>
 */
class MailServerFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'name' => $this->faker->name(),
      'priority' => $this->faker->randomNumber(),
      'active' => $this->faker->boolean(),
      'username' => $this->faker->userName(),
      'password' => $this->faker->password(),
      'smtp_host' => $this->faker->domainName(),
      'smtp_port' => $this->faker->numberBetween(1, 65535),
      'smtp_encryption' => $this->faker->randomElement(['tls', 'ssl']),
    ];
  }
}
