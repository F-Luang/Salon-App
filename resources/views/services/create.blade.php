@extends('layouts.app')
@section('title', 'Add Service')
@section('topbar-title', 'Add New Service')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Add New <span>Service</span></h1>
        <p class="page-sub">Add a new treatment or service to your menu</p>
    </div>
    <a href="{{ route('services.index') }}" class="btn btn-outline">← Back</a>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('services.store') }}">
        @csrf

        <div class="form-group">
            <label for="name">Service Name <span style="color:var(--rose)">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   placeholder="e.g. Gel Manicure, Nail Extension" required>
            @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label for="price">Price (₱) <span style="color:var(--rose)">*</span></label>
                <input type="number" id="price" name="price" value="{{ old('price') }}"
                       placeholder="350" min="0" step="0.01" required>
                @error('price') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="duration">Duration <span style="color:var(--rose)">*</span></label>
                <select id="duration" name="duration" required>
                    @foreach(['30 mins','45 mins','1 hour','1.5 hours','2 hours','2.5 hours','3 hours'] as $opt)
                        <option value="{{ $opt }}" {{ old('duration') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
                @error('duration') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3"
                      placeholder="Briefly describe what this service includes...">{{ old('description') }}</textarea>
            @error('description') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div style="display: flex; gap: 10px; justify-content: flex-end; padding-top: 8px;">
            <a href="{{ route('services.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Service</button>
        </div>
    </form>
</div>
@endsection
