<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Super Admin
    $user = User::factory()->create([
      'id' => 1,
      'first_name' => 'Super',
      'last_name' => 'Admin',
      'email' => 'admin@admin.com',
    ]);

    // give all permissions
    $user->givePermissionTo('*');
  }
}
