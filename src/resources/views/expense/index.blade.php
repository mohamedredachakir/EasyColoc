@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">💸 Shared Expenses</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Track who pays what and split the costs fairly.</p>
    </div>
    <a href="{{ route('expense.create') }}" class="btn" style="background: white; color: #d97706; height: fit-content; border: none; font-weight: 600;">ADD EXPENSE</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Expense Name</th>
                <th>Category</th>
                <th>Colocation</th>
                <th>By User</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
            <tr>
                <td style="font-weight: 600; color: var(--text);">{{ $expense->name }}</td>
                <td>{{ $expense->category->name ?? 'N/A' }}</td>
                <td>{{ $expense->colocation->name ?? 'N/A' }}</td>
                <td>{{ $expense->user->name ?? 'N/A' }}</td>
                <td style="font-weight: 700; color: var(--danger);">- {{ number_format($expense->amount, 2) }} MAD</td>
                <td>{{ $expense->expense_date }}</td>
                <td style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('expense.show', $expense->id) }}" class="btn" style="background: var(--bg); color: var(--text-light); border: 1px solid var(--border); padding: 0.25rem 0.5rem; font-size: 0.875rem;">VIEW</a>
                    @if($expense->user_id == auth()->id())
                        <a href="{{ route('expense.edit', $expense->id) }}" class="btn" style="background: #fef3c7; color: #d97706; padding: 0.25rem 0.5rem; font-size: 0.875rem;">EDIT</a>
                        <form action="{{ route('expense.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Delete this expense?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background: #fef2f2; color: #ef4444; padding: 0.25rem 0.5rem; font-size: 0.875rem; border: none;">DELETE</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: var(--text-light);">No shared expenses found. Log your first expense!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
