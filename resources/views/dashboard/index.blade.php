@extends('layouts.app')
@section('title', 'Dashboard')
@section('topbar-title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Good morning, <span>{{ Auth::user()->name }}</span></h1>
        <p class="page-sub">Here's your salon overview for today</p>
    </div>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary">+ New Booking</a>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Services</div>
        <div class="stat-value">{{ $totalServices }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Appointments</div>
        <div class="stat-value">{{ $totalAppointments }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Today's Bookings</div>
        <div class="stat-value">{{ $todayAppointments }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Revenue</div>
        <div class="stat-value accent">₱{{ number_format($totalRevenue, 0) }}</div>
    </div>
</div>

{{-- Two-column lower section --}}
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    {{-- Recent Appointments --}}
    <div class="card" style="margin-bottom: 0">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h2 style="font-family: 'DM Serif Display', serif; font-size: 17px; font-weight: 400;">Recent Appointments</h2>
            <a href="{{ route('appointments.index') }}" style="font-size: 12px; color: var(--rose); text-decoration: none;">View all →</a>
        </div>

        @if($recentAppointments->isEmpty())
            <div class="empty-state" style="padding: 24px">
                <p>No appointments yet</p>
                <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-sm">Book now</a>
            </div>
        @else
            @foreach($recentAppointments as $appt)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid var(--blush);">
                <div>
                    <div style="font-size: 13.5px; font-weight: 500;">{{ $appt->customer_name }}</div>
                    <div style="font-size: 11.5px; color: var(--text-muted);">{{ $appt->service->name }} · {{ \Carbon\Carbon::parse($appt->appointment_date)->format('M j') }} {{ $appt->appointment_time }}</div>
                </div>
                <span class="badge badge-{{ strtolower($appt->status) }}">{{ $appt->status }}</span>
            </div>
            @endforeach
        @endif
    </div>

    {{-- Payment Summary --}}
    <div class="card" style="margin-bottom: 0">
        <div style="margin-bottom: 18px;">
            <h2 style="font-family: 'DM Serif Display', serif; font-size: 17px; font-weight: 400;">Payment Overview</h2>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 16px; background: var(--blush); border-radius: 10px;">
                <span style="font-size: 13px; color: var(--text-muted);">Total Revenue</span>
                <span style="font-size: 20px; font-family: 'DM Serif Display', serif; color: var(--rose);">₱{{ number_format($totalRevenue, 0) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; border: 1px solid var(--border); border-radius: 10px;">
                <span style="font-size: 13px; color: var(--text-muted);">Paid Bookings</span>
                <span class="badge badge-paid">{{ $paidCount }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; border: 1px solid var(--border); border-radius: 10px;">
                <span style="font-size: 13px; color: var(--text-muted);">Unpaid / Pending</span>
                <span class="badge badge-unpaid">{{ $unpaidCount }}</span>
            </div>
            <a href="{{ route('payments.index') }}" class="btn btn-outline btn-sm" style="align-self: flex-end; margin-top: 4px;">View all payments →</a>
        </div>
    </div>

</div>
@endsection
