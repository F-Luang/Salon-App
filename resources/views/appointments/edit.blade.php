@extends('layouts.app')
@section('title', 'Edit Appointment')
@section('topbar-title', 'Edit Appointment')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit <span>Appointment</span></h1>
        <p class="page-sub">Update booking for {{ $appointment->customer_name }}</p>
    </div>
    <a href="{{ route('appointments.index') }}" class="btn btn-outline">← Back</a>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('appointments.update', $appointment) }}">
        @csrf @method('PUT')

        <div class="form-grid-2">
            <div class="form-group">
                <label>Customer Name <span style="color:var(--rose)">*</span></label>
                <input type="text" name="customer_name" value="{{ old('customer_name', $appointment->customer_name) }}" required>
                @error('customer_name') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Contact Number <span style="color:var(--rose)">*</span></label>
                <input type="text" name="customer_contact" value="{{ old('customer_contact', $appointment->customer_contact) }}" required>
                @error('customer_contact') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Service <span style="color:var(--rose)">*</span></label>
            <select name="service_id" required>
                @foreach($services as $service)
                    <option value="{{ $service->id }}"
                            {{ old('service_id', $appointment->service_id) == $service->id ? 'selected' : '' }}>
                        {{ $service->name }} — ₱{{ number_format($service->price, 0) }}
                    </option>
                @endforeach
            </select>
            @error('service_id') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label>Date <span style="color:var(--rose)">*</span></label>
                <input type="date" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date) }}" required>
                @error('appointment_date') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Time <span style="color:var(--rose)">*</span></label>
                <input type="time" name="appointment_time" value="{{ old('appointment_time', $appointment->appointment_time) }}" required>
                @error('appointment_time') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status">
                @foreach(['Pending','Confirmed','Done','Cancelled'] as $st)
                    <option value="{{ $st }}" {{ old('status', $appointment->status) === $st ? 'selected' : '' }}>{{ $st }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Notes</label>
            <textarea name="notes" rows="3">{{ old('notes', $appointment->notes) }}</textarea>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:8px">
            <a href="{{ route('appointments.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Appointment</button>
        </div>
    </form>
</div>
@endsection
