@extends('layouts.app')
@section('title', 'Appointments')
@section('topbar-title', 'Appointments')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Appointments</h1>
        <p class="page-sub">Manage bookings and customer schedules</p>
    </div>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary">+ New Booking</a>
</div>

<div class="card-flush">
    @if($appointments->isEmpty())
        <div class="empty-state">
            <div class="icon">◷</div>
            <p>No appointments booked yet.</p>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary">Book first appointment</a>
        </div>
    @else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Date & Time</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appt)
                <tr>
                    <td>
                        <div style="font-weight: 500;">{{ $appt->customer_name }}</div>
                        <div style="font-size: 12px; color: var(--text-muted);">{{ $appt->customer_contact }}</div>
                    </td>
                    <td>{{ $appt->service->name }}</td>
                    <td>
                        <div style="font-size: 13px;">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M j, Y') }}</div>
                        <div style="font-size: 12px; color: var(--text-muted);">{{ \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') }}</div>
                    </td>
                    <td style="font-weight: 500; color: var(--rose);">₱{{ number_format($appt->service->price, 2) }}</td>
                    <td><span class="badge badge-{{ strtolower($appt->status) }}">{{ $appt->status }}</span></td>
                    <td>
                        @if($appt->payment)
                            <span class="badge badge-{{ strtolower($appt->payment->status) }}">
                                {{ $appt->payment->status }}
                            </span>
                        @else
                            <span style="color: var(--text-light); font-size: 12px;">—</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                            <a href="{{ route('appointments.show', $appt) }}" class="btn btn-outline btn-sm">View</a>
                            <a href="{{ route('appointments.edit', $appt) }}" class="btn btn-outline btn-sm">Edit</a>
                            @if($appt->payment && $appt->payment->status === 'Unpaid')
                                <button onclick="openPayModal({{ $appt->id }}, '{{ $appt->customer_name }}', '{{ $appt->service->name }}', '{{ number_format($appt->service->price, 2) }}', {{ $appt->payment->id }})"
                                        class="btn btn-primary btn-sm">Pay</button>
                            @endif
                            <form method="POST" action="{{ route('appointments.destroy', $appt) }}"
                                  onsubmit="return confirm('Delete this appointment?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">✕</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- Pay Modal --}}
<div class="modal-backdrop" id="pay-modal">
    <div class="modal">
        <h2 class="modal-title">Process Payment</h2>
        <div id="pay-summary" style="background: var(--blush); border-radius: 12px; padding: 18px; margin-bottom: 20px;">
            <div id="pay-customer" style="font-weight: 500; font-size: 15px;"></div>
            <div id="pay-service"  style="font-size: 13px; color: var(--text-muted); margin-top: 4px;"></div>
            <div id="pay-amount"   style="font-size: 26px; font-family: 'DM Serif Display', serif; color: var(--rose); margin-top: 10px;"></div>
        </div>
        <form method="POST" id="pay-form">
            @csrf
            <div class="form-group">
                <label>Payment Method <span style="color:var(--rose)">*</span></label>
                <select name="payment_method" required>
                    <option value="Cash">Cash</option>
                    <option value="GCash">GCash</option>
                    <option value="Maya">Maya</option>
                    <option value="Card">Card</option>
                </select>
            </div>
            <div class="form-group">
                <label>Notes (optional)</label>
                <input type="text" name="notes" placeholder="e.g. Paid via QR code">
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closePayModal()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-success">✓ Mark as Paid</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openPayModal(apptId, name, service, amount, payId) {
    document.getElementById('pay-customer').textContent = name;
    document.getElementById('pay-service').textContent  = service;
    document.getElementById('pay-amount').textContent   = '₱' + amount;
    document.getElementById('pay-form').action = '/payments/' + payId + '/process';
    document.getElementById('pay-modal').classList.add('open');
}
function closePayModal() {
    document.getElementById('pay-modal').classList.remove('open');
}
document.getElementById('pay-modal').addEventListener('click', function(e) {
    if (e.target === this) closePayModal();
});
</script>
@endpush
@endsection
