@extends('layouts.app')
@section('title', 'Payments')
@section('topbar-title', 'Payments')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Payments</h1>
        <p class="page-sub">Transaction history and payment management</p>
    </div>
</div>

{{-- Stats --}}
<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
        <div class="stat-label">Total Revenue</div>
        <div class="stat-value accent">₱{{ number_format($totalRevenue, 0) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Paid Transactions</div>
        <div class="stat-value">{{ $paidCount }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pending Payment</div>
        <div class="stat-value">{{ $unpaidCount }}</div>
    </div>
</div>

<div class="card-flush">
    @if($payments->isEmpty())
        <div class="empty-state">
            <div class="icon">◈</div>
            <p>No payment records yet.</p>
        </div>
    @else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Paid At</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td style="color:var(--text-muted)">{{ $payment->id }}</td>
                    <td>
                        <div style="font-weight:500">{{ $payment->appointment->customer_name }}</div>
                        <div style="font-size:12px;color:var(--text-muted)">{{ $payment->appointment->customer_contact }}</div>
                    </td>
                    <td>{{ $payment->appointment->service->name }}</td>
                    <td style="font-size:13px">{{ \Carbon\Carbon::parse($payment->appointment->appointment_date)->format('M j, Y') }}</td>
                    <td style="font-weight:500;color:var(--rose)">₱{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->payment_method ?? '—' }}</td>
                    <td style="font-size:12px;color:var(--text-muted)">
                        {{ $payment->paid_at ? $payment->paid_at->format('M j, g:i A') : '—' }}
                    </td>
                    <td><span class="badge badge-{{ strtolower($payment->status) }}">{{ $payment->status }}</span></td>
                    <td>
                        <div style="display:flex;gap:6px">
                            @if($payment->status === 'Unpaid')
                                <button onclick="openPayModal({{ $payment->id }}, '{{ $payment->appointment->customer_name }}', '{{ $payment->appointment->service->name }}', '{{ number_format($payment->amount, 2) }}')"
                                        class="btn btn-primary btn-sm">Pay</button>
                            @else
                                <form method="POST" action="{{ route('payments.unpaid', $payment) }}"
                                      onsubmit="return confirm('Revert payment to Unpaid?')">
                                    @csrf
                                    <button type="submit" class="btn btn-outline btn-sm">Revert</button>
                                </form>
                            @endif
                            <a href="{{ route('payments.show', $payment) }}" class="btn btn-outline btn-sm">Receipt</a>
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
        <div id="pay-summary" style="background:var(--blush);border-radius:12px;padding:18px;margin-bottom:20px">
            <div id="pay-customer" style="font-weight:500;font-size:15px"></div>
            <div id="pay-service"  style="font-size:13px;color:var(--text-muted);margin-top:4px"></div>
            <div id="pay-amount"   style="font-size:26px;font-family:'DM Serif Display',serif;color:var(--rose);margin-top:10px"></div>
        </div>
        <form method="POST" id="pay-form">
            @csrf
            <div class="form-group">
                <label>Payment Method <span style="color:var(--rose)">*</span></label>
                <select name="payment_method" required>
                    <option>Cash</option>
                    <option>GCash</option>
                    <option>Maya</option>
                    <option>Card</option>
                </select>
            </div>
            <div class="form-group">
                <label>Notes (optional)</label>
                <input type="text" name="notes" placeholder="e.g. Exact change, Reference no.">
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closePayModal()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-success">✓ Confirm Payment</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openPayModal(payId, name, service, amount) {
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
