@extends('layouts.app')
@section('title', 'Appointment Details')
@section('topbar-title', 'Appointment Details')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Appointment <span>#{{ $appointment->id }}</span></h1>
        <p class="page-sub">Booking details for {{ $appointment->customer_name }}</p>
    </div>
    <div style="display:flex;gap:10px">
        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-outline">Edit</a>
        <a href="{{ route('appointments.index') }}" class="btn btn-outline">← Back</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">
    <div class="card" style="margin-bottom:0">
        <h2 style="font-family:'DM Serif Display',serif;font-size:17px;font-weight:400;margin-bottom:20px;">Booking Information</h2>
        <dl class="detail-grid">
            <div class="detail-row"><dt>Customer</dt><dd>{{ $appointment->customer_name }}</dd></div>
            <div class="detail-row"><dt>Contact</dt><dd>{{ $appointment->customer_contact }}</dd></div>
            <div class="detail-row"><dt>Service</dt><dd>{{ $appointment->service->name }}</dd></div>
            <div class="detail-row"><dt>Price</dt><dd style="font-weight:500;color:var(--rose)">₱{{ number_format($appointment->service->price, 2) }}</dd></div>
            <div class="detail-row"><dt>Duration</dt><dd>{{ $appointment->service->duration }}</dd></div>
            <div class="detail-row"><dt>Date</dt><dd>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</dd></div>
            <div class="detail-row"><dt>Time</dt><dd>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</dd></div>
            <div class="detail-row"><dt>Status</dt><dd><span class="badge badge-{{ strtolower($appointment->status) }}">{{ $appointment->status }}</span></dd></div>
            <div class="detail-row"><dt>Notes</dt><dd style="color:var(--text-muted)">{{ $appointment->notes ?: 'None' }}</dd></div>
            <div class="detail-row"><dt>Booked on</dt><dd style="color:var(--text-muted);font-size:13px">{{ $appointment->created_at->format('M j, Y g:i A') }}</dd></div>
        </dl>
    </div>

    <div>
        <div class="card" style="margin-bottom:16px">
            <h2 style="font-family:'DM Serif Display',serif;font-size:17px;font-weight:400;margin-bottom:16px;">Payment</h2>
            @if($appointment->payment)
                <div style="margin-bottom:12px">
                    <span class="badge badge-{{ strtolower($appointment->payment->status) }}" style="font-size:13px;padding:5px 14px">
                        {{ $appointment->payment->status }}
                    </span>
                </div>
                @if($appointment->payment->status === 'Paid')
                    <div style="font-size:13px;color:var(--text-muted);line-height:1.8">
                        <div><strong>Method:</strong> {{ $appointment->payment->payment_method }}</div>
                        <div><strong>Paid at:</strong> {{ $appointment->payment->paid_at->format('M j, Y g:i A') }}</div>
                        @if($appointment->payment->notes)
                        <div><strong>Notes:</strong> {{ $appointment->payment->notes }}</div>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('payments.unpaid', $appointment->payment) }}" style="margin-top:14px"
                          onsubmit="return confirm('Revert this payment to Unpaid?')">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm" style="width:100%">Revert to Unpaid</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('payments.process', $appointment->payment) }}">
                        @csrf
                        <div class="form-group">
                            <label>Payment Method</label>
                            <select name="payment_method">
                                <option>Cash</option><option>GCash</option><option>Maya</option><option>Card</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success" style="width:100%">✓ Mark as Paid</button>
                    </form>
                @endif
            @else
                <p style="font-size:13px;color:var(--text-muted)">No payment record found.</p>
            @endif
        </div>

        <form method="POST" action="{{ route('appointments.destroy', $appointment) }}"
              onsubmit="return confirm('Permanently delete this appointment?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" style="width:100%">Delete Appointment</button>
        </form>
    </div>
</div>
@endsection
