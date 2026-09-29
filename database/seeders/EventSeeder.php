<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::create([
            'title' => 'test1',
            'description' => 'test',
            'event_date' => '2026-10-08',
        ]);

        Event::create([
            'title' => 'test2',
            'description' => 'test',
            'event_date' => '2026-10-22',
        ]);

        Event::create([
            'title' => 'test3',
            'description' => 'test',
            'event_date' => '2026-11-05',
        ]);

        Event::create([
            'title' => 'test4',
            'description' => 'test',
            'event_date' => '2026-11-19',
        ]);
    }
}
