<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Service;
use App\Services\AppointmentService;
use App\Services\ClientService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentServiceTest extends TestCase
{
    use RefreshDatabase;

    private AppointmentService $appointmentService;
    private ClientService $clientService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->appointmentService = new AppointmentService();
        $this->clientService      = new ClientService();
    }

    public function test_client_service_creates_new_client(): void
    {
        $client = $this->clientService->findOrCreate([
            'name'  => 'محمد علي',
            'email' => 'mohammed@test.com',
            'phone' => '0622222222',
        ]);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertDatabaseHas('clients', ['email' => 'mohammed@test.com']);
    }

    public function test_client_service_reuses_existing_client(): void
    {
        Client::create([
            'name'  => 'محمد علي',
            'email' => 'mohammed@test.com',
            'phone' => '0622222222',
        ]);

        $this->clientService->findOrCreate([
            'name'  => 'محمد علي',
            'email' => 'mohammed@test.com',
            'phone' => '0622222222',
        ]);

        $this->assertEquals(1, Client::where('email', 'mohammed@test.com')->count());
    }

    public function test_appointment_service_confirms_appointment(): void
    {
        $client   = Client::factory()->create();
        $employee = Employee::factory()->create();

        $appointment = Appointment::create([
            'client_id'   => $client->id,
            'employee_id' => $employee->id,
            'start_time'  => now()->addDay(),
            'finish_time' => now()->addDay()->addHours(4),
            'status'      => 0,
        ]);

        $confirmed = $this->appointmentService->confirm($appointment, 500.0);

        $this->assertEquals(1, $confirmed->status);
        $this->assertEquals(500.0, $confirmed->deposit);
    }

    public function test_appointment_service_confirms_without_deposit(): void
    {
        $client   = Client::factory()->create();
        $employee = Employee::factory()->create();

        $appointment = Appointment::create([
            'client_id'   => $client->id,
            'employee_id' => $employee->id,
            'start_time'  => now()->addDay(),
            'finish_time' => now()->addDay()->addHours(4),
            'status'      => 0,
        ]);

        $confirmed = $this->appointmentService->confirm($appointment);

        $this->assertEquals(1, $confirmed->status);
        $this->assertNull($confirmed->deposit);
    }

    public function test_appointment_service_creates_from_booking(): void
    {
        $client   = Client::factory()->create();
        $employee = Employee::factory()->create();
        $service  = Service::factory()->create(['price' => 300]);

        $data = [
            'date'              => now()->addDays(3)->format('Y-m-d H:i:s'),
            'services'          => [$service->id],
            'total_price'       => 300,
            'event_location_id' => null,
        ];

        $appointment = $this->appointmentService->createFromBooking($data, $client->id);

        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertEquals(0, $appointment->status);
        $this->assertEquals($client->id, $appointment->client_id);
        $this->assertEquals(300, $appointment->price);
        $this->assertTrue($appointment->services->contains($service->id));
    }
}
