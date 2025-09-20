<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


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

        DB::table('users')->insert([
            'id' => 100,
            'username' => 'brad',
            'email' => 'brad@local',
            'password' => Hash::make('qwertyqwerty'),
            'isAdmin' => 1
        ]);

        DB::table('users')->insert([
            'id' => 200,
            'username' => 'barksalot',
            'email' => 'barksalot@local',
            'password' => Hash::make('qwertyqwerty')
        ]);

        DB::table('users')->insert([
            'id' => 300,
            'username' => 'meowsalot',
            'email' => 'meowsalot@local',
            'password' => Hash::make('qwertyqwerty')
        ]);

        $now = now();

        // Define how many posts each user should get
        $usersWithPostCounts = [
            100 => 8,   // Tech user
            200 => 10,  // Pets & lifestyle user
            300 => 15,  // Travel user
        ];

        foreach ($usersWithPostCounts as $userId => $count) {
            for ($i = 1; $i <= $count; $i++) {
                $title = '';
                $body  = '';

                switch ($userId) {
                    case 100: // Tech
                        $title = fake()->randomElement([
                            "Learning Laravel the Easy Way",
                            "Why I Love PHP in 2025",
                            "Debugging Like a Pro",
                            "My Favorite VS Code Extensions",
                            "Tips for Clean JavaScript Code",
                            "Why Testing Saves Your Career",
                            "Mastering Git Branching",
                            "Is AI Replacing Developers?"
                        ]);
                        $body = fake()->paragraphs(rand(2, 4), true);
                        break;

                    case 200: // Pets & lifestyle
                        $title = fake()->randomElement([
                            "Being a Dog Is Fun",
                            "How I Trained My Puppy",
                            "The Best Toys for Active Dogs",
                            "Why Walks Are My Favorite Time",
                            "Living with Cats and Dogs",
                            "Healthy Snacks for Pets",
                            "Funny Things My Dog Does",
                            "Bath Time Adventures",
                            "How Pets Make Life Better",
                            "My Morning Routine with Dogs"
                        ]);
                        $body = fake()->paragraphs(rand(2, 4), true);
                        break;

                    case 300: // Travel
                        $title = fake()->randomElement([
                            "Exploring the Streets of Rome",
                            "Why I Fell in Love with Paris",
                            "Backpacking Through the Alps",
                            "Top 5 Beaches in Greece",
                            "Cultural Shocks in Japan",
                            "Hiking the Andes Mountains",
                            "Street Food Adventures in Bangkok",
                            "How to Travel on a Budget",
                            "Best Cities for Digital Nomads",
                            "Road Trip Across the USA",
                            "Discovering Hidden Gems in Spain",
                            "Why Solo Travel Changed My Life",
                            "Camping Under the Northern Lights",
                            "Boat Trips Around Croatia",
                            "The Magic of Christmas in Vienna"
                        ]);
                        $body = fake()->paragraphs(rand(2, 4), true);
                        break;
                }

                DB::table('posts')->insert([
                    'user_id'    => $userId,
                    'title'      => $title,
                    'body'       => $body,
                    'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
                    'updated_at' => $now,
                ]);
            }
        }

        DB::table('follows')->insert([
            'user_id' => 200,
            'followed_user_id' => 100
        ]);

        DB::table('follows')->insert([
            'user_id' => 300,
            'followed_user_id' => 100
        ]);

        DB::table('follows')->insert([
            'user_id' => 300,
            'followed_user_id' => 200
        ]);
    }
}
