@extends('layouts.app')
@section('title', 'Services')
@section('topbar-title', 'Services')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Services</h1>
        <p class="page-sub">Manage your salon's service offerings</p>
    </div>
    <a href="{{ route('services.create') }}" class="btn btn-primary">+ Add Service</a>
</div>

<div class="card-flush">
    @if($services->isEmpty())
        <div class="empty-state">
            <div class="icon">✦</div>
            <p>No services added yet.</p>
            <a href="{{ route('services.create') }}" class="btn btn-primary">Add your first service</a>
        </div>
    @else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service Name</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $i => $service)
                <tr>
                    <td style="color: var(--text-muted); width: 40px;">{{ $i + 1 }}</td>
                    <td><strong>{{ $service->name }}</strong></td>
                    <td style="font-weight: 500; color: var(--rose);">₱{{ number_format($service->price, 2) }}</td>
                    <td>
                        <span style="background: var(--blush); padding: 3px 10px; border-radius: 20px; font-size: 12px; color: var(--text-muted);">
                            {{ $service->duration }}
                        </span>
                    </td>
                    <td style="color: var(--text-muted); font-size: 13px; max-width: 220px;">
                        {{ $service->description ?? '—' }}
                    </td>
                    <td>
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form method="POST" action="{{ route('services.destroy', $service) }}"
                                  onsubmit="return confirm('Delete \'{{ $service->name }}\'? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
@endsection
