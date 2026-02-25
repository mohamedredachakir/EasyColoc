<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EasyColoc') }}</title>

    <!-- Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">

    {{--
        Vite bundles:
        · resources/css/app.css  → @imports premium_ui.css → then Tailwind
        · resources/js/app.js   → imports premium_ui.js + Alpine
    --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<div class="app-shell">

    {{-- ═══════════════ SIDEBAR ═══════════════ --}}
    <aside class="sidebar-premium">

        {{-- Logo --}}
        <div class="logo-wrap">
            <div class="logo-mark">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div class="logo-name">EasyColoc<span>.</span></div>
        </div>

        {{-- Nav --}}
        <nav class="nav-primary">

            <x-nav-link-premium href="{{ route('dashboard') }}" icon="home" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-nav-link-premium>

            <x-nav-link-premium href="{{ route('colocations.index') }}" icon="spaces" :active="request()->routeIs('colocations.*')">
                Living Spaces
            </x-nav-link-premium>

            <x-nav-link-premium href="{{ route('expenses.index') }}" icon="ledger" :active="request()->routeIs('expenses.*')">
                Global Ledger
            </x-nav-link-premium>

            <x-nav-link-premium href="{{ route('invitations.index') }}" icon="inbox" :active="request()->routeIs('invitations.*')">
                Inbox
            </x-nav-link-premium>

            @if(auth()->check() && auth()->user()->role === \App\Enums\RoleEnum::ADMIN->value)
                <div class="nav-section-label">System</div>
                <x-nav-link-premium href="{{ route('admin.index') }}" icon="admin" :active="request()->routeIs('admin.*')">
                    Admin Panel
                </x-nav-link-premium>
            @endif

        </nav>

        {{-- User Card --}}
        <div class="sidebar-user">
            <div class="sidebar-user-row">
                <div class="sidebar-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="sidebar-user-meta">
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-email">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                         style="width:13px;height:13px;flex-shrink:0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sign out
                </button>
            </form>
        </div>

    </aside>

    {{-- ═══════════════ MAIN ═══════════════ --}}
    <main class="main-content-premium">

        @if(session('success'))
            <div class="toast toast-success" id="toast-ok">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                     style="width:18px;height:18px;flex-shrink:0;">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="toast toast-error" id="toast-err">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                     style="width:18px;height:18px;flex-shrink:0;">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{ $slot }}

    </main>
</div>

</body>
</html>
