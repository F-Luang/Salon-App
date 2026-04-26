<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@petalnails.com',
            'password' => Hash::make('password'),
        ]);

        // Sample services
        $services = [
            ['name' => 'Classic Manicure',  'price' => 250,  'duration' => '30 mins',  'description' => 'Basic nail shaping, cuticle care, and regular polish.'],
            ['name' => 'Gel Manicure',       'price' => 450,  'duration' => '1 hour',   'description' => 'Long-lasting gel polish with UV curing.'],
            ['name' => 'Classic Pedicure',   'price' => 350,  'duration' => '45 mins',  'description' => 'Foot soak, exfoliation, nail trim, and polish.'],
            ['name' => 'Gel Pedicure',       'price' => 550,  'duration' => '1 hour',   'description' => 'Gel polish pedicure with UV curing.'],
            ['name' => 'Nail Extension',     'price' => 800,  'duration' => '2 hours',  'description' => 'Acrylic or gel nail extensions for added length.'],
            ['name' => 'Nail Art',           'price' => 150,  'duration' => '30 mins',  'description' => 'Custom nail art designs per nail or full set.'],
            ['name' => 'Mani + Pedi Combo',  'price' => 550,  'duration' => '1.5 hours','description' => 'Classic manicure and pedicure combined package.'],
        ];

        foreach ($services as $svc) {
            Service::create($svc);
        }

        // Sample appointments
        $appointments = [
            ['customer_name' => 'Maria Santos', 'customer_contact' => '09171234567', 'service_id' => 2, 'appointment_date' => now()->toDateString(), 'appointment_time' => '09:00', 'status' => 'Confirmed'],
            ['customer_name' => 'Ana Reyes',    'customer_contact' => '09182223333', 'service_id' => 3, 'appointment_date' => now()->toDateString(), 'appointment_time' => '11:00', 'status' => 'Done'],
            ['customer_name' => 'Carla Cruz',   'customer_contact' => '09194445555', 'service_id' => 1, 'appointment_date' => now()->addDay()->toDateString(), 'appointment_time' => '14:00', 'status' => 'Pending'],
        ];

        foreach ($appointments as $appt) {
            $a = Appointment::create($appt);
            // Create a payment record for each
            $service = Service::find($appt['service_id']);
            $isPaid  = $appt['status'] === 'Done';
            Payment::create([
                'appointment_id' => $a->id,
                'amount'         => $service->price,
                'status'         => $isPaid ? 'Paid' : 'Unpaid',
                'payment_method' => $isPaid ? 'Cash' : null,
                'paid_at'        => $isPaid ? now() : null,
            ]);
        }
    }
}
