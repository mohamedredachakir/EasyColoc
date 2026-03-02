@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">📂 Category: {{ $category->name }}</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Expenses grouped under this category.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('category.edit', $category->id) }}" class="btn" style="background: white; color: #7c3aed; font-weight: 600;">EDIT</a>
        <a href="{{ route('category.index') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid white;">BACK</a>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <h3 style="margin-top: 0;">Expenses in this Category</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Expense Name</th>
                <th>Colocation</th>
                <th>By User</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($category->expenses as $expense)
            <tr>
                <td style="font-weight: 600; color: var(--text);">{{ $expense->name }}</td>
                <td>{{ $expense->colocation->name ?? 'N/A' }}</td>
                <td>{{ $expense->user->name ?? 'N/A' }}</td>
                <td style="font-weight: 700; color: var(--danger);">- {{ number_format($expense->amount, 2) }} MAD</td>
                <td>{{ $expense->expense_date }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: var(--text-light);">No expenses found for this category.</td>
            </tr>
            @endforelse
        </tbody>
        @if($category->expenses->count() > 0)
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: 700; padding: 1rem;">TOTAL:</td>
                <td style="font-weight: 700; color: var(--danger); padding: 1rem;">- {{ number_format($category->expenses->sum('amount'), 2) }} MAD</td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
@endsection
