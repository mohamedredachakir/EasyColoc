@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">💳 Payments Management</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">All payments recorded across all colocations.</p>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Colocation</th>
                <th>User</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td style="font-weight: 600;">{{ $payment->name }}</td>
                <td style="color: var(--success); font-weight: 700;">{{ number_format($payment->amount, 2) }} MAD</td>
                <td>{{ $payment->colocation->name }}</td>
                <td>{{ $payment->user->name }}</td>
                <td>{{ $payment->payment_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
