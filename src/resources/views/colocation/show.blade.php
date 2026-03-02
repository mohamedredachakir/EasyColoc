@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, var(--primary) 0%, #4f46e5 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">🏠 {{ $colocation->name }}</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Managing your shared household status.</p>
    </div>
    <div style="text-align: right;">
        <span class="status-badge" style="background: rgba(255,255,255,0.2); color: white;">{{ $colocation->status }}</span>
        <p style="margin: 0.5rem 0 0; opacity: 0.8;">Owner: {{ $colocation->owner_id == auth()->id() ? 'You' : $colocation->owner_id }}</p>
    </div>
</div>

<div class="grid" style="margin-top: 2rem;">
    <!-- Active Members -->
    <div class="card" style="grid-column: span 2;">
        <h3 style="margin-top: 0; display: flex; align-items: center; gap: 0.5rem;">
            👥 Roommates
        </h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Joined</th>
                    <th>Balance</th>
                    <th>Reputation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($colocation->users as $user)
                <tr>
                    <td style="font-weight: 600;">{{ $user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->pivot->entry_date)->format('M d, Y') }}</td>
                    <td>
                        <span style="font-weight: 700; color: {{ $user->pivot->amount >= 0 ? 'var(--success)' : 'var(--danger)' }}">
                            {{ number_format($user->pivot->amount, 2) }} MAD
                        </span>
                    </td>
                    <td>⭐ {{ $user->reputation }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <h3 style="margin-top: 0;">Actions</h3>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <a href="{{ route('expense.create', ['colocation_id' => $colocation->id]) }}" class="btn btn-primary" style="justify-content: center;">LOG EXPENSE</a>
            <a href="{{ route('payment.create', ['colocation_id' => $colocation->id]) }}" class="btn" style="background: #3b82f6; color: white; justify-content: center;">MAKE PAYMENT</a>
            
            @if($colocation->owner_id == auth()->id())
                <a href="{{ route('invitations.create', ['colocation_id' => $colocation->id]) }}" class="btn" style="background: #ec4899; color: white; justify-content: center;">INVITE ROOMMATE</a>
            @endif

            <form action="{{ route('colocation.leave', $colocation->id) }}" method="POST" onsubmit="return confirm('Note: Leaving with a negative balance will decrease your reputation!')">
                @csrf
                <button type="submit" class="btn" style="width: 100%; justify-content: center; background: #fef2f2; color: var(--danger); border: 1px solid #fee2e2;">LEAVE COLOCATION</button>
            </form>
        </div>
    </div>
</div>

<div class="grid" style="margin-top: 2rem;">
    <!-- Recent Expenses -->
    <div class="card">
        <h3 style="margin-top: 0;">Recent Expenses</h3>
        <ul style="list-style: none; padding: 0;">
            @forelse($colocation->expenses()->latest()->take(5)->get() as $expense)
            <li style="padding: 0.75rem 0; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between;">
                <div>
                    <div style="font-weight: 600;">{{ $expense->name }}</div>
                    <small style="color: var(--text-light);">{{ $expense->user->name }} • {{ $expense->expense_date }}</small>
                </div>
                <div style="color: var(--danger); font-weight: 700;">-{{ number_format($expense->amount, 2) }}</div>
            </li>
            @empty
            <li style="color: var(--text-light);">No expenses recorded yet.</li>
            @endforelse
        </ul>
    </div>

    <!-- Recent Payments -->
    <div class="card">
        <h3 style="margin-top: 0;">Recent Payments</h3>
        <ul style="list-style: none; padding: 0;">
            @forelse($colocation->payments()->latest()->take(5)->get() as $payment)
            <li style="padding: 0.75rem 0; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between;">
                <div>
                    <div style="font-weight: 600;">{{ $payment->name }}</div>
                    <small style="color: var(--text-light);">{{ $payment->user->name }} • {{ $payment->payment_date }}</small>
                </div>
                <div style="color: var(--success); font-weight: 700;">+{{ number_format($payment->amount, 2) }}</div>
            </li>
            @empty
            <li style="color: var(--text-light);">No payments recorded yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
