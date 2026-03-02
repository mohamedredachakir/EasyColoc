@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">🏠 Colocations</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Join a colocation and start sharing expenses together.</p>
    </div>
    <a href="{{ route('colocation.create') }}" class="btn" style="background: white; color: #059669; height: fit-content; border: none; font-weight: 600;">CREATE NEW</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Colocation Name</th>
                <th>Owner</th>
                <th>Status</th>
                <th>My Balance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($colocations as $pivot)
            <tr>
                <td style="font-weight: 600; color: var(--text);">{{ $pivot->colocation->name }}</td>
                <td>{{ $pivot->colocation->owner_id == auth()->id() ? 'You' : $pivot->colocation->owner_id }}</td>
                <td><span class="status-badge status-active">{{ $pivot->colocation->status }}</span></td>
                <td>
                    <span style="font-weight: 700; color: {{ $pivot->amount >= 0 ? 'var(--success)' : 'var(--danger)' }}">
                        {{ number_format($pivot->amount, 2) }} MAD
                    </span>
                </td>
                <td style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('colocation.show', $pivot->colocation_id) }}" class="btn" style="background: var(--bg); color: var(--text-light); border: 1px solid var(--border);">VIEW</a>
                    <form action="{{ route('colocation.leave', $pivot->colocation_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to leave this colocation?')">
                        @csrf
                        <button type="submit" class="btn" style="background: #fef2f2; color: var(--danger); border: 1px solid #fee2e2;">LEAVE</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: var(--text-light);">No colocations found. Create or join one!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
