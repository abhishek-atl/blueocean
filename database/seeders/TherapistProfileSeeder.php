<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TherapistProfile;
use App\Models\TherapistSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TherapistProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all therapist users (users with user_type = 'Therapist')
        $therapists = User::where('user_type', 'Therapist')->doesntHave('therapist_profile')->get();

        foreach ($therapists as $therapist) {
            // Create therapist profile
            TherapistProfile::factory()->create([
                'user_id' => $therapist->id,
            ]);

            // Create therapist schedule if doesn't exist
            if (!$therapist->schedule) {
                TherapistSchedule::create([
                    'user_id' => $therapist->id,
                    'mon' => '11:00,11:30,12:00,12:30,13:00,13:30,14:00',
                    'tue' => '11:00,11:30,12:00,12:30,13:00,13:30,14:00',
                    'wed' => '11:00,11:30,12:00,12:30,13:00,13:30,14:00',
                    'thu' => '11:00,11:30,12:00,12:30,13:00,13:30,14:00',
                    'fri' => '11:00,11:30,12:00,12:30,13:00,13:30,14:00',
                    'sat' => '11:00,11:30,12:00,12:30,13:00,13:30,14:00',
                    'sun' => '11:00,11:30,12:00,12:30,13:00,13:30,14:00',
                ]);
            }
        }

        $this->command->info('Therapist profiles seeded successfully!');
    }
}
