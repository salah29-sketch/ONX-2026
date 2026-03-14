<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_reservation_creates_appointment_and_client(): void
    {
        Mail::fake();

        $service  = Service::factory()->create(['price' => 500]);
        $employee = Employee::factory()->create();

        $response = $this->postJson('/reservation-api', [
            'name'     => 'سارة العمري',
            'email'    => 'sara@test.com',
            'phone'    => '0611111111',
            'date'     => now()->addDays(5)->format('Y-m-d'),
            'services' => [$service->id],
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('clients', ['email' => 'sara@test.com']);
        $this->assertDatabaseHas('appointments', ['status' => 0]);
    }

    public function test_reservation_fails_without_name(): void
    {
        $service = Service::factory()->create();

        $response = $this->postJson('/reservation-api', [
            'email'    => 'test@test.com',
            'phone'    => '0611111111',
            'date'     => now()->addDays(5)->format('Y-m-d'),
            'services' => [$service->id],
        ]);

        $response->assertStatus(422);
    }

    public function test_reservation_fails_without_services(): void
    {
        $response = $this->postJson('/reservation-api', [
            'name'  => 'أحمد',
            'email' => 'test@test.com',
            'phone' => '0611111111',
            'date'  => now()->addDays(5)->format('Y-m-d'),
        ]);

        $response->assertStatus(422);
    }

    public function test_reservation_requires_custom_location_when_other_selected(): void
    {
        $service = Service::factory()->create();

        $response = $this->postJson('/reservation-api', [
            'name'              => 'أحمد',
            'email'             => 'test@test.com',
            'phone'             => '0611111111',
            'date'              => now()->addDays(5)->format('Y-m-d'),
            'services'          => [$service->id],
            'event_location_id' => 'other',
        ]);

        $response->assertStatus(422);
    }

    public function test_reservation_fails_with_invalid_service_id(): void
    {
        $response = $this->postJson('/reservation-api', [
            'name'     => 'أحمد',
            'email'    => 'test@test.com',
            'phone'    => '0611111111',
            'date'     => now()->addDays(5)->format('Y-m-d'),
            'services' => [99999],
        ]);

        $response->assertStatus(422);
    }

    public function test_existing_client_is_reused_not_duplicated(): void
    {
        Mail::fake();

        $service  = Service::factory()->create();
        $employee = Employee::factory()->create();

        Client::create([
            'name'  => 'سارة العمري',
            'email' => 'sara@test.com',
            'phone' => '0611111111',
        ]);

        $this->postJson('/reservation-api', [
            'name'     => 'سارة العمري',
            'email'    => 'sara@test.com',
            'phone'    => '0611111111',
            'date'     => now()->addDays(5)->format('Y-m-d'),
            'services' => [$service->id],
        ]);

        $this->assertEquals(1, Client::where('email', 'sara@test.com')->count());
    }
}
