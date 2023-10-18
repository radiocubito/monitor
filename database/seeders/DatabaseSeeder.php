<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        if (app()->environment('local')) {
            $user = User::factory()->create([
                'name' => 'Oliver Servín',
                'email' => 'oliver@radiocubito.com',
            ]);

            Site::factory()->create([
                'user_id' => $user->id,
                'scheme' => 'http',
                'domain' => 'radiocubito.com',
                'default' => 0,
            ]);

            Site::factory()->create([
                'user_id' => $user->id,
                'scheme' => 'http',
                'domain' => 'oliverservin.com',
                'default' => 0,
            ]);
        } else {
            $user = User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@radiocubito.com',
            ]);
        }
    }
}
