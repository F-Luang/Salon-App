<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('appointment.service')->latest()->get();
        $totalRevenue = Payment::where('status', 'Paid')->sum('amount');
        $paidCount = Payment::where('status', 'Paid')->count();
        $unpaidCount = Payment::where('status', 'Unpaid')->count();

        return view('payments.index', compact('payments', 'totalRevenue', 'paidCount', 'unpaidCount'));
    }

    public function process(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:Cash,GCash,Maya,Card',
            'notes' => 'nullable|string|max:500',
        ]);

        $payment->update([
            'status' => 'Paid',
            'payment_method' => $validated['payment_method'],
            'paid_at' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        $payment->appointment->update(['status' => 'Done']);

        return redirect()->route('payments.index')
            ->with('success', 'Payment processed for ' . $payment->appointment->customer_name . '.');
    }

    public function show(Payment $payment)
    {
        $payment->load('appointment.service');
        return view('payments.show', compact('payment'));
    }

    public function markUnpaid(Payment $payment)
    {
        $payment->update([
            'status' => 'Unpaid',
            'payment_method' => null,
            'paid_at' => null,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment reverted to Unpaid.');
    }
}