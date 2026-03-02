@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">💳 Payment Details</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Settle transaction overview.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        @if($payment->user_id == auth()->id())
            <a href="{{ route('payment.edit', $payment->id) }}" class="btn" style="background: white; color: #2563eb; font-weight: 600;">EDIT</a>
        @endif
        <a href="{{ route('payment.index') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid white;">BACK</a>
    </div>
</div>

<div class="grid" style="margin-top: 2rem;">
    <div class="card" style="grid-column: span 2;">
        <h3 style="margin-top: 0; color: var(--text-light);">Reference / Note</h3>
        <p style="font-size: 1.5rem; font-weight: 600; margin-bottom: 2rem;">{{ $payment->name }}</p>

        <div class="grid" style="grid-template-columns: repeat(2, 1fr); gap: 2rem;">
            <div>
                <h4 style="margin: 0; color: var(--text-light);">Amount</h4>
                <p style="font-size: 2rem; font-weight: 700; color: var(--success); margin: 0.5rem 0;">+ {{ number_format($payment->amount, 2) }} MAD</p>
            </div>
            <div>
                <h4 style="margin: 0; color: var(--text-light);">Colocation</h4>
                <p style="font-size: 1.25rem; font-weight: 600; margin: 0.5rem 0;">{{ $payment->colocation->name ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-top: 0;">Details</h3>
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="padding: 1rem 0; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between;">
                <span style="color: var(--text-light);">Paid By</span>
                <span style="font-weight: 600;">{{ $payment->user->name }}</span>
            </li>
            <li style="padding: 1rem 0; display: flex; justify-content: space-between;">
                <span style="color: var(--text-light);">Date</span>
                <span style="font-weight: 600;">{{ $payment->payment_date }}</span>
            </li>
        </ul>
    </div>
</div>
@endsection
