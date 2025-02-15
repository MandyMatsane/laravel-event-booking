<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Event;
use App\Models\Review;
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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Event::truncate();
        // User::truncate();

        $this->call(AdminSeeder::class);
        $this->call(OrganizerSeeder::class);

        User::factory(10)->create();
        Category::factory(5)->create();
        Event::factory(10)->create();
        Booking::factory(10)->create();
        Review::factory(15)->create();
    }
}
