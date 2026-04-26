<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Petal Nails') — Salon Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --rose: #e8547a;
            --rose-light: #fce7ed;
            --rose-dark: #b8345a;
            --blush: #f9f0f3;
            --cream: #fffcfb;
            --text: #1a0a12;
            --text-muted: #7a5567;
            --text-light: #b8a0ac;
            --border: #ead8df;
            --surface: #ffffff;
            --success: #2d7a4f;
            --success-bg: #e6f5ee;
            --success-border: #b8e0c9;
            --danger: #c0392b;
            --danger-bg: #fdecea;
            --danger-border: #f5c0bc;
            --warn: #a06000;
            --warn-bg: #fff3e0;
            --sidebar-w: 230px;
        }

        body { font-family: 'DM Sans', sans-serif; background: var(--blush); color: var(--text); min-height: 100vh; }

        /* ── Layout ── */
        .layout { display: flex; min-height: 100vh; }

        .sidebar {
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 10;
        }
        .sidebar-brand {
            padding: 24px 22px 20px;
            border-bottom: 1px solid var(--border);
        }
        .brand-name {
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: var(--rose);
            letter-spacing: -0.3px;
            display: block;
        }
        .brand-sub {
            font-size: 11px;
            color: var(--text-muted);
            font-style: italic;
            margin-top: 2px;
            display: block;
        }
        nav { padding: 14px 0; flex: 1; }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 22px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 400;
            border-left: 3px solid transparent;
            transition: all .15s;
        }
        .nav-link:hover { background: var(--blush); color: var(--text); }
        .nav-link.active { background: var(--rose-light); color: var(--rose-dark); border-left-color: var(--rose); font-weight: 500; }
        .nav-icon { font-size: 17px; width: 22px; text-align: center; flex-shrink: 0; }
        .nav-label { font-size: 13px; }

        .sidebar-footer {
            padding: 16px 22px;
            border-top: 1px solid var(--border);
        }
        .user-info { font-size: 12px; color: var(--text-muted); margin-bottom: 10px; line-height: 1.5; }
        .user-info strong { color: var(--text); display: block; font-size: 13px; }

        .main-wrap { margin-left: var(--sidebar-w); flex: 1; }
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .topbar-title { font-size: 15px; font-weight: 500; color: var(--text); }
        .topbar-date { font-size: 12px; color: var(--text-muted); }

        .content { padding: 32px; }

        /* ── Components ── */
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 28px; gap: 16px; }
        .page-title { font-family: 'DM Serif Display', serif; font-size: 28px; color: var(--text); letter-spacing: -0.4px; }
        .page-title span { color: var(--rose); }
        .page-sub { font-size: 13px; color: var(--text-muted); margin-top: 3px; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            border-radius: 9px;
            font-size: 13.5px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all .18s;
            white-space: nowrap;
        }
        .btn-primary   { background: var(--rose); color: #fff; }
        .btn-primary:hover { background: var(--rose-dark); }
        .btn-outline   { background: transparent; border: 1.5px solid var(--border); color: var(--text-muted); }
        .btn-outline:hover { border-color: var(--rose); color: var(--rose); }
        .btn-danger    { background: transparent; border: 1.5px solid var(--danger-border); color: var(--danger); }
        .btn-danger:hover { background: var(--danger-bg); }
        .btn-success   { background: var(--success); color: #fff; }
        .btn-success:hover { opacity: .9; }
        .btn-sm { padding: 6px 14px; font-size: 12.5px; border-radius: 7px; }
        .btn-logout { width: 100%; padding: 8px 14px; background: transparent; border: 1.5px solid var(--border); border-radius: 8px; font-size: 13px; font-family: 'DM Sans', sans-serif; color: var(--text-muted); cursor: pointer; transition: .2s; text-align: center; text-decoration: none; display: block; }
        .btn-logout:hover { border-color: var(--rose); color: var(--rose); }

        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 24px; margin-bottom: 24px; }
        .card-flush { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; margin-bottom: 24px; }

        /* ── Stats ── */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
        .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 20px 22px; }
        .stat-label { font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); }
        .stat-value { font-size: 28px; font-weight: 300; color: var(--text); margin-top: 6px; font-family: 'DM Serif Display', serif; }
        .stat-value.accent { color: var(--rose); }

        /* ── Tables ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        thead th { text-align: left; padding: 12px 16px; font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); border-bottom: 2px solid var(--border); background: #fdf8f9; white-space: nowrap; }
        tbody td { padding: 13px 16px; border-bottom: 1px solid var(--blush); color: var(--text); vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #fdf5f7; }

        /* ── Badges ── */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 500; }
        .badge-paid      { background: #d9f2e6; color: #1a6b40; }
        .badge-unpaid    { background: #fdecea; color: #b02020; }
        .badge-pending   { background: #fff0d4; color: #8a5500; }
        .badge-confirmed { background: #e3eeff; color: #1a4ba0; }
        .badge-done      { background: #e8f5e9; color: #2e7d32; }
        .badge-cancelled { background: #f3f3f3; color: #777; }

        /* ── Forms ── */
        .form-card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 32px; max-width: 680px; }
        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 12px; font-weight: 500; color: var(--text-muted); margin-bottom: 7px; text-transform: uppercase; letter-spacing: .5px; }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color .2s;
            background: var(--cream);
            color: var(--text);
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus { border-color: var(--rose); }
        .form-group .error { font-size: 12px; color: var(--danger); margin-top: 5px; }

        /* ── Alerts ── */
        .alert { padding: 13px 18px; border-radius: 10px; font-size: 13.5px; margin-bottom: 20px; border: 1px solid; }
        .alert-success { background: var(--success-bg); color: var(--success); border-color: var(--success-border); }
        .alert-error   { background: var(--danger-bg);  color: var(--danger);  border-color: var(--danger-border); }
        .alert-warn    { background: var(--warn-bg);    color: var(--warn);    border-color: #ffd08a; }

        /* ── Empty state ── */
        .empty-state { text-align: center; padding: 56px 24px; color: var(--text-muted); }
        .empty-state .icon { font-size: 44px; margin-bottom: 14px; opacity: .5; }
        .empty-state p { font-size: 14px; margin-bottom: 20px; }

        /* ── Detail rows ── */
        .detail-grid { display: grid; grid-template-columns: 160px 1fr; gap: 0; }
        .detail-row { display: contents; }
        .detail-row dt, .detail-row dd { padding: 12px 0; border-bottom: 1px solid var(--blush); font-size: 14px; }
        .detail-row dt { font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); padding-right: 16px; }

        /* ── Modal ── */
        .modal-backdrop { display: none; position: fixed; inset: 0; background: rgba(26,10,18,.4); z-index: 50; align-items: center; justify-content: center; }
        .modal-backdrop.open { display: flex; }
        .modal { background: var(--surface); border-radius: 18px; padding: 32px; width: 480px; max-width: 95vw; border: 1px solid var(--border); max-height: 90vh; overflow-y: auto; }
        .modal-title { font-family: 'DM Serif Display', serif; font-size: 22px; color: var(--text); margin-bottom: 24px; }
        .modal-footer { display: flex; gap: 10px; justify-content: flex-end; margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--border); }

        /* ── Responsive adjustments ── */
        @media (max-width: 900px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .form-grid-2 { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="layout">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <span class="brand-name">✦ Petal Nails</span>
            <span class="brand-sub">Salon Management System</span>
        </div>
        <nav>
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon">⊞</span>
                <span class="nav-label">Dashboard</span>
            </a>
            <a href="{{ route('services.index') }}"
               class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
                <span class="nav-icon">✦</span>
                <span class="nav-label">Services</span>
            </a>
            <a href="{{ route('appointments.index') }}"
               class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                <span class="nav-icon">◷</span>
                <span class="nav-label">Appointments</span>
            </a>
            <a href="{{ route('payments.index') }}"
               class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <span class="nav-icon">◈</span>
                <span class="nav-label">Payments</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <strong>{{ Auth::user()->name }}</strong>
                {{ Auth::user()->email }}
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Sign Out</button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="main-wrap">
        <div class="topbar">
            <span class="topbar-title">@yield('topbar-title', 'Dashboard')</span>
            <span class="topbar-date">{{ now()->format('l, F j, Y') }}</span>
        </div>
        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">✓ &nbsp;{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">✕ &nbsp;{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
@stack('scripts')
</body>
</html>
