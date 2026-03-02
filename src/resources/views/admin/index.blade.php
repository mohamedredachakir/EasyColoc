@extends('layouts.app')

@section('content')
<div class="card" style="background: linear-gradient(135deg, #1f2937 0%, #111827 100%); color: white; border: none; padding: 2.5rem;">
    <h1 style="margin: 0; font-size: 2.25rem;">Admin Dashboard 🛡️</h1>
    <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Global system overview and management.</p>
</div>

<div class="grid" style="margin-top: 2rem;">
    <div class="card">
        <h3 style="margin-top: 0;">Total Users</h3>
        <p style="font-size: 2rem; font-weight: 700; color: var(--primary); margin: 0;">{{ \App\Models\User::count() }}</p>
        <a href="{{ route('admin.users') }}" style="display: block; margin-top: 1rem; color: var(--primary); text-decoration: none; font-weight: 500;">Manage Users →</a>
    </div>
    
    <div class="card">
        <h3 style="margin-top: 0;">Total Colocations</h3>
        <p style="font-size: 2rem; font-weight: 700; color: var(--success); margin: 0;">{{ \App\Models\Colocation::count() }}</p>
        <a href="{{ route('admin.colocations') }}" style="display: block; margin-top: 1rem; color: var(--success); text-decoration: none; font-weight: 500;">Manage Colocations →</a>
    </div>

    <div class="card">
        <h3 style="margin-top: 0;">Total Expenses</h3>
        <p style="font-size: 2rem; font-weight: 700; color: var(--danger); margin: 0;">{{ \App\Models\Expense::count() }}</p>
        <a href="{{ route('admin.expenses') }}" style="display: block; margin-top: 1rem; color: var(--danger); text-decoration: none; font-weight: 500;">View Expenses →</a>
    </div>

    <div class="card">
        <h3 style="margin-top: 0;">Total Payments</h3>
        <p style="font-size: 2rem; font-weight: 700; color: #3b82f6; margin: 0;">{{ \App\Models\Payment::count() }}</p>
        <a href="{{ route('admin.payments') }}" style="display: block; margin-top: 1rem; color: #3b82f6; text-decoration: none; font-weight: 500;">View Payments →</a>
    </div>
</div>

<div class="grid" style="margin-top: 1rem;">
    <div class="card">
        <h3 style="margin-top: 0;">Categories</h3>
        <p style="color: var(--text-light);">Manage expense categories.</p>
        <a href="{{ route('admin.categories') }}" class="btn btn-primary" style="margin-top: 1rem;">Manage Categories</a>
    </div>

    <div class="card">
        <h3 style="margin-top: 0;">Invitations</h3>
        <p style="color: var(--text-light);">Monitor all invitations sent.</p>
        <a href="{{ route('admin.invitations') }}" class="btn" style="margin-top: 1rem; background: #ec4899; color: white;">View Invitations</a>
    </div>
</div>
@endsection
