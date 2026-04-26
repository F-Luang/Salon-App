<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('service', 'payment')->latest()->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        return view('appointments.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_contact' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string|max:1000',
        ]);

        $appointment = Appointment::create($validated);

        $service = Service::find($validated['service_id']);
        Payment::create([
            'appointment_id' => $appointment->id,
            'amount' => $service->price,
            'status' => 'Unpaid',
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment booked for ' . $validated['customer_name'] . '.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load('service', 'payment');
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        return view('appointments.edit', compact('appointment', 'services'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_contact' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:Pending,Confirmed,Done,Cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $appointment->update($validated);

        if ($appointment->payment) {
            $service = Service::find($validated['service_id']);
            $appointment->payment->update(['amount' => $service->price]);
        }

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }
}