@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: auto;">
    <h1 style="margin-top: 0; color: #3b82f6;">MAKE A PAYMENT</h1>
    <p style="color: var(--text-light); margin-bottom: 2rem;">Add money to your colocation balance to settle your share.</p>
    
    <form action="{{ route('payment.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Payment Reference / Note</label>
            <input type="text" name="name" id="name" placeholder="e.g. Monthly top-up, Settlement" required>
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
            <label for="amount">Amount (MAD)</label>
            <input type="number" step="0.01" name="amount" id="amount" placeholder="0.00" required>
        </div>

        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn" style="background: #3b82f6; color: white; flex: 1; padding: 1rem;">SUBMIT PAYMENT</button>
            <a href="{{ route('payment.index') }}" class="btn" style="background: var(--bg); border: 1px solid var(--border); padding: 1rem;">CANCEL</a>
        </div>
    </form>
</div>
@endsection
