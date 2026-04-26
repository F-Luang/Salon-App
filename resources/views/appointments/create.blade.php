@extends('layouts.app')
@section('title', 'New Booking')
@section('topbar-title', 'New Appointment')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">New <span>Booking</span></h1>
        <p class="page-sub">Schedule a new appointment for a customer</p>
    </div>
    <a href="{{ route('appointments.index') }}" class="btn btn-outline">← Back</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start;">

    <div class="form-card" style="max-width: 100%;">
        <form method="POST" action="{{ route('appointments.store') }}" id="appt-form">
            @csrf

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="customer_name">Customer Name <span style="color:var(--rose)">*</span></label>
                    <input type="text" id="customer_name" name="customer_name"
                           value="{{ old('customer_name') }}" placeholder="Full name" required>
                    @error('customer_name') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="customer_contact">Contact Number <span style="color:var(--rose)">*</span></label>
                    <input type="text" id="customer_contact" name="customer_contact"
                           value="{{ old('customer_contact') }}" placeholder="09XX XXX XXXX" required>
                    @error('customer_contact') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="service_id">Service <span style="color:var(--rose)">*</span></label>
                <select id="service_id" name="service_id" onchange="updatePreview()" required>
                    <option value="">— Select a service —</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}"
                                data-price="{{ $service->price }}"
                                data-duration="{{ $service->duration }}"
                                data-desc="{{ $service->description }}"
                                {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }} — ₱{{ number_format($service->price, 0) }}
                        </option>
                    @endforeach
                </select>
                @error('service_id') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="appointment_date">Date <span style="color:var(--rose)">*</span></label>
                    <input type="date" id="appointment_date" name="appointment_date"
                           value="{{ old('appointment_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                    @error('appointment_date') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="appointment_time">Time <span style="color:var(--rose)">*</span></label>
                    <input type="time" id="appointment_time" name="appointment_time"
                           value="{{ old('appointment_time', '09:00') }}" required>
                    @error('appointment_time') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="notes">Notes / Special Requests</label>
                <textarea id="notes" name="notes" rows="3"
                          placeholder="Any preferences or special requests...">{{ old('notes') }}</textarea>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end; padding-top: 8px;">
                <a href="{{ route('appointments.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Book Appointment</button>
            </div>
        </form>
    </div>

    {{-- Service Preview Panel --}}
    <div id="service-preview" style="display: none;">
        <div class="card" style="margin-bottom: 0; border-left: 3px solid var(--rose);">
            <div style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); margin-bottom: 12px;">Service Summary</div>
            <div id="prev-name" style="font-family: 'DM Serif Display', serif; font-size: 18px; margin-bottom: 8px;"></div>
            <div id="prev-price" style="font-size: 22px; font-weight: 300; color: var(--rose); font-family: 'DM Serif Display', serif;"></div>
            <div id="prev-duration" style="font-size: 13px; color: var(--text-muted); margin-top: 4px;"></div>
            <div id="prev-desc" style="font-size: 13px; color: var(--text-muted); margin-top: 10px; padding-top: 10px; border-top: 1px solid var(--border);"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updatePreview() {
    const sel = document.getElementById('service_id');
    const opt = sel.options[sel.selectedIndex];
    const panel = document.getElementById('service-preview');
    if (!sel.value) { panel.style.display = 'none'; return; }
    panel.style.display = 'block';
    document.getElementById('prev-name').textContent     = opt.text.split('—')[0].trim();
    document.getElementById('prev-price').textContent    = '₱' + Number(opt.dataset.price).toLocaleString();
    document.getElementById('prev-duration').textContent = opt.dataset.duration;
    document.getElementById('prev-desc').textContent     = opt.dataset.desc || '';
}
document.addEventListener('DOMContentLoaded', updatePreview);
</script>
@endpush
@endsection
