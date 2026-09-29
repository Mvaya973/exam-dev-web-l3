<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_and_edit_pages_display_the_event_form(): void
    {
        $this->get(route('events.create'))->assertOk();

        $event = Event::create([
            'title' => 'Conférence',
            'description' => 'Une conférence sur le campus.',
            'event_date' => '2026-10-15',
        ]);

        $this->get(route('events.edit', $event))->assertOk();
    }

    public function test_an_event_can_be_created_and_the_user_is_redirected_to_edit_it(): void
    {
        $response = $this->post(route('events.store'), [
            'title' => 'Forum des associations',
            'description' => 'Rencontre avec les associations du campus.',
            'event_date' => '2026-10-15',
            'location' => 'Amphithéâtre A',
        ]);

        $event = Event::firstOrFail();

        $response->assertRedirect(route('events.edit', $event));
        $this->assertDatabaseHas('events', [
            'title' => 'Forum des associations',
            'event_date' => '2026-10-15',
            'location' => 'Amphithéâtre A',
        ]);
        $this->assertDatabaseCount('events', 1);
    }

    public function test_an_event_can_be_updated(): void
    {
        $event = Event::create([
            'title' => 'Ancien titre',
            'description' => 'Ancienne description',
            'event_date' => '2026-10-15',
            'location' => 'Ancien lieu',
        ]);

        $response = $this->put(route('events.update', $event), [
            'title' => 'Nouveau titre',
            'description' => 'Nouvelle description',
            'event_date' => '2026-10-20',
            'location' => 'Nouvelle salle',
        ]);

        $response->assertRedirect(route('events.show', $event));
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Nouveau titre',
            'description' => 'Nouvelle description',
            'event_date' => '2026-10-20',
            'location' => 'Nouvelle salle',
        ]);
    }

    public function test_invalid_event_data_is_rejected_on_creation_and_update(): void
    {
        $this->post(route('events.store'), [
            'title' => str_repeat('x', 151),
            'description' => '',
            'event_date' => 'not-a-date',
            'location' => str_repeat('x', 151),
        ])->assertSessionHasErrors(['title', 'description', 'event_date', 'location']);

        $event = Event::create([
            'title' => 'Titre valide',
            'description' => 'Description valide',
            'event_date' => '2026-10-15',
        ]);

        $this->put(route('events.update', $event), [
            'title' => '',
            'description' => '',
            'event_date' => 'not-a-date',
        ])->assertSessionHasErrors(['title', 'description', 'event_date']);
    }

    public function test_an_event_can_be_deleted(): void
    {
        $event = Event::create([
            'title' => 'Événement à supprimer',
            'description' => 'Description',
            'event_date' => '2026-10-15',
        ]);

        $response = $this->delete(route('events.destroy', $event));

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }
}