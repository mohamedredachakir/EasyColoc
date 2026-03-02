<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', ' RYALmaychiit ') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premium.css') }}">
</head>
<body>
    <nav>
        <div class="nav-content">
            <a href="{{ route('dashboard') }}" style="font-size: 1.5rem; font-weight: 700; color: var(--primary); text-decoration: none;"> RYALmaychiit </a>
            <div class="nav-links">
                <a href="{{ route('colocation.index') }}">Colocations</a>
                <a href="{{ route('expense.index') }}">Expenses</a>
                <a href="{{ route('payment.index') }}">Payments</a>
                <a href="{{ route('category.index') }}">Categories</a>
                <a href="{{ route('invitations.index') }}">Invitations</a>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('admin.index') }}" style="color: var(--primary); font-weight: 700;">Admin</a>
                @endif
                @auth
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn" style="color: var(--danger); font-weight: 500;">Logout</button>
                </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container">
        @if(session('success'))
            <div class="card" style="background: #ecfdf5; border: 1px solid #10b981; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="card" style="background: #fef2f2; border: 1px solid #ef4444; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="card" style="background: #fffbeb; border: 1px solid #f59e0b; color: #92400e; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
