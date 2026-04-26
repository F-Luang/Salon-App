<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalServices = Service::count();
        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('appointment_date', $today)->count();
        $totalRevenue = Payment::where('status', 'Paid')->sum('amount');
        $paidCount = Payment::where('status', 'Paid')->count();
        $unpaidCount = Payment::where('status', 'Unpaid')->count();

        $recentAppointments = Appointment::with('service', 'payment')
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard.index', compact(
            'totalServices',
            'totalAppointments',
            'todayAppointments',
            'totalRevenue',
            'paidCount',
            'unpaidCount',
            'recentAppointments'
        ));
    }
}