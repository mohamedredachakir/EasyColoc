@extends('layouts.app')

@section('content')
<div class="card" style="background: linear-gradient(135deg, var(--primary) 0%, #4f46e5 100%); color: white; border: none; padding: 2.5rem;">
    <h1 style="margin: 0; font-size: 2.25rem;">Welcome, {{ auth()->user()->name }}! 🏠</h1>
    <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">This is your testing hub for the colocation logic.</p>
</div>

<div class="grid">
    <!-- Quick Stats -->
    <div class="card">
        <h3 style="margin-top: 0;">Reputation</h3>
        <p style="font-size: 2rem; font-weight: 700; color: var(--primary); margin: 0;">{{ auth()->user()->reputation ?? 0 }}</p>
    </div>
    
    <div class="card">
        <h3 style="margin-top: 0;">My Active Colocations</h3>
        <p style="font-size: 2rem; font-weight: 700; color: var(--success); margin: 0;">{{ \App\Models\ColocationUser::where('user_id', auth()->id())->count() }}</p>
    </div>

    <div class="card">
        <h3 style="margin-top: 0;">Total Balance</h3>
        @php
            $totalBalance = \App\Models\ColocationUser::where('user_id', auth()->id())->sum('amount');
        @endphp
        <p style="font-size: 2rem; font-weight: 700; color: {{ $totalBalance >= 0 ? 'var(--success)' : 'var(--danger)' }}; margin: 0;">{{ number_format($totalBalance, 2) }} MAD</p>
    </div>
</div>

<h2 style="margin-top: 2rem; color: var(--text-light);">Test Dashboard</h2>

<div class="grid">
    <div class="card">
        <h3>🏠 Colocation Logic</h3>
        <p>Test creating, joining, and leaving colocations.</p>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="{{ route('colocation.create') }}" class="btn btn-primary">Create New Colocation</a>
            <a href="{{ route('colocation.index') }}" class="btn" style="background: var(--bg); border: 1px solid var(--border);">Manage My Colocations</a>
        </div>
    </div>

    <div class="card">
        <h3>💸 Expense & Balance Logic</h3>
        <p>Test how expenses affect member balances.</p>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="{{ route('expense.create') }}" class="btn btn-primary">Record New Expense</a>
            <a href="{{ route('expense.index') }}" class="btn" style="background: var(--bg); border: 1px solid var(--border);">Expense History</a>
        </div>
    </div>

    <div class="card">
        <h3>💳 Payment Logic</h3>
        <p>Test adding money to improve your balance.</p>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="{{ route('payment.create') }}" class="btn btn-primary">Make a Payment</a>
            <a href="{{ route('payment.index') }}" class="btn" style="background: var(--bg); border: 1px solid var(--border);">Payment History</a>
        </div>
    </div>

    <div class="card">
        <h3>✉️ Invitation Logic</h3>
        <p>Invite others and manage pending requests.</p>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="{{ route('invitations.index') }}" class="btn btn-primary">Check Invitations</a>
            <a href="{{ route('invitations.create') }}" class="btn" style="background: var(--bg); border: 1px solid var(--border);">Send New Invitation</a>
        </div>
    </div>
</div>
@endsection
