<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $adminRole = \App\Models\Role::where('slug', 'admin')->first();
        $moderatorRole = \App\Models\Role::where('slug', 'moderator')->first();
        $userRole = \App\Models\Role::where('slug', 'user')->first();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);

        User::factory()->create([
            'name' => 'Moderator',
            'email' => 'mod@example.com',
            'password' => bcrypt('password'),
            'role_id' => $moderatorRole->id,
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role_id' => $userRole->id,
        ]);
    }
}
