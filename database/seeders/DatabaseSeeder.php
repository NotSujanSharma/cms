<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Club;
use App\Models\Event;
use App\Models\News;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear tables in reverse order to avoid foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        News::truncate();
        Event::truncate();
        DB::table('event_user')->truncate();
        DB::table('club_user')->truncate();
        Club::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.ca',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create sub-admin user
        $subAdmin = User::create([
            'name' => 'Sub Admin User',
            'email' => 'subadmin@example.ca',
            'password' => Hash::make('password'),
            'role' => 'subadmin',
        ]);

        // Create regular users
        $users = [];
        for ($i = 1; $i <= 20; $i++) {
            $users[] = User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }

        // Create clubs
        $clubs = [
            'Sports Club' => 'sports_club.jpg',
            'Science Club' => 'science_club.jpg',
            'Art Club' => 'art_club.jpg',
            'Music Club' => 'music_club.jpg',
            'Drama Club' => 'drama_club.jpg',
        ];

        $clubModels = [];
        foreach ($clubs as $clubName => $image) {
            $clubModels[] = Club::create([
                'name' => $clubName,
                'image_path' => "clubs/$image"
            ]);
        }

        // Assign users to clubs (each user joins 1-3 clubs randomly)
        foreach ($users as $user) {
            $randomClubs = array_rand($clubModels, rand(1, 3));
            if (!is_array($randomClubs)) {
                $randomClubs = [$randomClubs];
            }
            foreach ($randomClubs as $clubIndex) {
                $user->clubs()->attach($clubModels[$clubIndex]->id);
            }
        }

        // Add admin and subadmin to all clubs
        foreach ($clubModels as $club) {
            $admin->clubs()->attach($club->id);
            $subAdmin->clubs()->attach($club->id);
        }

        // Create events for each club
        $eventTypes = [
            'Meeting' => 'Regular club meeting',
            'Competition' => 'Annual competition',
            'Workshop' => 'Skill development workshop',
            'Exhibition' => 'Members showcase',
            'Tournament' => 'Inter-club tournament'
        ];

        foreach ($clubModels as $club) {
            // Create 3 events per club
            for ($i = 0; $i < 3; $i++) {
                $eventType = array_rand($eventTypes);
                $event = Event::create([
                    'name' => $club->name . " " . $eventType,
                    'event_date' => Carbon::now()->addDays(rand(1, 60)),
                    'club_id' => $club->id,
                    'description' => $eventTypes[$eventType],
                ]);

                // Add random participants (5-15 users per event)
                $participants = array_rand(array_flip(array_column($users, 'id')), rand(5, 15));
                $event->participants()->attach($participants);
            }
        }

        // Create news for each club
        $newsTemplates = [
            'Achievement' => 'Club members won prestigious competition',
            'Announcement' => 'Important updates about upcoming activities',
            'Report' => 'Summary of recent successful event',
            'Feature' => 'Spotlight on outstanding club members',
            'Update' => 'New equipment/facilities announcement'
        ];

        foreach ($clubModels as $club) {
            // Create 5 news items per club
            for ($i = 0; $i < 5; $i++) {
                $newsType = array_rand($newsTemplates);
                News::create([
                    'headline' => $club->name . " " . $newsType,
                    'description' => $newsTemplates[$newsType],
                    'picture_path' => "news/{$club->name}_news_$i.jpg",
                    'date' => Carbon::now()->subDays(rand(0, 30)),
                    'club_id' => $club->id,
                ]);
            }
        }
    }
}