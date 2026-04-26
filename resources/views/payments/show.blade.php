@extends('layouts.app')
@section('title', 'Payment Receipt')
@section('topbar-title', 'Payment Receipt')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Receipt <span>#{{ $payment->id }}</span></h1>
        <p class="page-sub">Payment record for {{ $payment->appointment->customer_name }}</p>
    </div>
    <div style="display:flex;gap:10px">
        <button onclick="window.print()" class="btn btn-outline">🖨 Print</button>
        <a href="{{ route('payments.index') }}" class="btn btn-outline">← Back</a>
    </div>
</div>

<div class="card" style="max-width:540px">
    {{-- Receipt header --}}
    <div style="text-align:center;padding-bottom:20px;border-bottom:1px solid var(--border);margin-bottom:20px">
        <div style="font-family:'DM Serif Display',serif;font-size:24px;color:var(--rose)">✦ Petal Nails</div>
        <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-style:italic">Official Receipt</div>
        <div style="font-size:11px;color:var(--text-light);margin-top:8px">Receipt #{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</div>
    </div>

    <dl class="detail-grid">
        <div class="detail-row"><dt>Customer</dt><dd style="font-weight:500">{{ $payment->appointment->customer_name }}</dd></div>
        <div class="detail-row"><dt>Contact</dt><dd>{{ $payment->appointment->customer_contact }}</dd></div>
        <div class="detail-row"><dt>Service</dt><dd>{{ $payment->appointment->service->name }}</dd></div>
        <div class="detail-row"><dt>Duration</dt><dd>{{ $payment->appointment->service->duration }}</dd></div>
        <div class="detail-row"><dt>Appointment</dt><dd>{{ \Carbon\Carbon::parse($payment->appointment->appointment_date)->format('F j, Y') }} at {{ \Carbon\Carbon::parse($payment->appointment->appointment_time)->format('g:i A') }}</dd></div>
        <div class="detail-row"><dt>Payment Status</dt><dd><span class="badge badge-{{ strtolower($payment->status) }}">{{ $payment->status }}</span></dd></div>
        @if($payment->payment_method)
        <div class="detail-row"><dt>Method</dt><dd>{{ $payment->payment_method }}</dd></div>
        @endif
        @if($payment->paid_at)
        <div class="detail-row"><dt>Paid At</dt><dd>{{ $payment->paid_at->format('F j, Y g:i A') }}</dd></div>
        @endif
        @if($payment->notes)
        <div class="detail-row"><dt>Notes</dt><dd style="color:var(--text-muted)">{{ $payment->notes }}</dd></div>
        @endif
    </dl>

    {{-- Total --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:20px;padding-top:20px;border-top:2px solid var(--border)">
        <span style="font-size:14px;font-weight:500;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted)">Total Amount</span>
        <span style="font-size:30px;font-family:'DM Serif Display',serif;color:var(--rose)">₱{{ number_format($payment->amount, 2) }}</span>
    </div>

    <div style="text-align:center;margin-top:24px;font-size:12px;color:var(--text-light);font-style:italic">
        Thank you for visiting Petal Nails! 💅
    </div>
</div>

@push('styles')
<style>
@media print {
    .sidebar, .topbar, .page-header .btn, button { display: none !important; }
    .main-wrap { margin-left: 0 !important; }
    .content { padding: 20px !important; }
}
</style>
@endpush
@endsection
