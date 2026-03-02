@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: auto;">
    <h1 style="margin-top: 0; color: #3b82f6;">EDIT PAYMENT</h1>
    <p style="color: var(--text-light); margin-bottom: 2rem;">Update the details of your recorded payment.</p>
    
    <form action="{{ route('payment.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Payment Reference / Note</label>
            <input type="text" name="name" id="name" placeholder="e.g. Monthly top-up, Settlement" required value="{{ old('name', $payment->name) }}" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border);">
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="colocation_id" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Colocation</label>
            <select name="colocation_id" id="colocation_id" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border);">
                @php
                    $colocations = \App\Models\Colocation::whereHas('users', fn($q) => $q->where('user_id', auth()->id()))->get();
                @endphp
                @foreach($colocations as $colocation)
                    <option value="{{ $colocation->id }}" {{ $payment->colocation_id == $colocation->id ? 'selected' : '' }}>{{ $colocation->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="amount" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Amount (MAD)</label>
            <input type="number" step="0.01" name="amount" id="amount" placeholder="0.00" required value="{{ old('amount', $payment->amount) }}" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border);">
        </div>

        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn" style="background: #3b82f6; color: white; flex: 1; padding: 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; border: none;">UPDATE PAYMENT</button>
            <a href="{{ route('payment.index') }}" class="btn" style="background: var(--bg); border: 1px solid var(--border); flex: 1; padding: 1rem; text-align: center; border-radius: 0.5rem; text-decoration: none; color: var(--text);">CANCEL</a>
        </div>
    </form>
</div>
@endsection
