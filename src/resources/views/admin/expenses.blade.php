@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #ef4444 0%, #991b1b 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">💸 Expenses Management</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">All expenses recorded across all colocations.</p>
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
                <th>Category</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->id }}</td>
                <td style="font-weight: 600;">{{ $expense->name }}</td>
                <td style="color: var(--danger); font-weight: 700;">{{ number_format($expense->amount, 2) }} MAD</td>
                <td>{{ $expense->colocation->name }}</td>
                <td>{{ $expense->user->name }}</td>
                <td>{{ $expense->category->name }}</td>
                <td>{{ $expense->expense_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
