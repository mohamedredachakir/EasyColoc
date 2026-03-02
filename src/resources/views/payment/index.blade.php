@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">💳 Payments</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Settle your debts or top up your colocation balance.</p>
    </div>
    <a href="{{ route('payment.create') }}" class="btn" style="background: white; color: #2563eb; height: fit-content; border: none; font-weight: 600;">MAKE PAYMENT</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Colocation</th>
                <th>By User</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
            <tr>
                <td style="font-weight: 600; color: var(--text);">{{ $payment->name }}</td>
                <td>{{ $payment->colocation->name ?? 'N/A' }}</td>
                <td>{{ $payment->user->name ?? 'N/A' }}</td>
                <td style="font-weight: 700; color: var(--success);">+ {{ number_format($payment->amount, 2) }} MAD</td>
                <td>{{ $payment->payment_date }}</td>
                <td style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('payment.show', $payment->id) }}" class="btn" style="background: var(--bg); color: var(--text-light); border: 1px solid var(--border); padding: 0.25rem 0.5rem; font-size: 0.875rem;">VIEW</a>
                    @if($payment->user_id == auth()->id())
                        <a href="{{ route('payment.edit', $payment->id) }}" class="btn" style="background: #e0f2fe; color: #3b82f6; padding: 0.25rem 0.5rem; font-size: 0.875rem;">EDIT</a>
                        <form action="{{ route('payment.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Delete this payment?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background: #fef2f2; color: #ef4444; padding: 0.25rem 0.5rem; font-size: 0.875rem; border: none;">DELETE</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: var(--text-light);">No payments found. Improve your balance today!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
