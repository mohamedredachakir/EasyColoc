@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: auto;">
    <h1 style="margin-top: 0; color: #f59e0b;">LOG NEW EXPENSE</h1>
    <p style="color: var(--text-light); margin-bottom: 2rem;">When you buy something for the house, log it here to split the cost.</p>
    
    <form action="{{ route('expense.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Expense Description</label>
            <input type="text" name="name" id="name" placeholder="e.g. Groceries, Electricity bill" required>
        </div>

        <div class="form-group">
            <label for="colocation_id">Colocation</label>
            <select name="colocation_id" id="colocation_id" required>
                @foreach($colocations as $colocation)
                    <option value="{{ $colocation->id }}">{{ $colocation->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="amount">Amount (MAD)</label>
            <input type="number" step="0.01" name="amount" id="amount" placeholder="0.00" required>
        </div>

        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn" style="background: #f59e0b; color: white; flex: 1; padding: 1rem;">LOG EXPENSE</button>
            <a href="{{ route('expense.index') }}" class="btn" style="background: var(--bg); border: 1px solid var(--border); padding: 1rem;">CANCEL</a>
        </div>
    </form>
</div>
@endsection
