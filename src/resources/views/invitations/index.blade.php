@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">✉️ Invitations</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Join households you've been invited to.</p>
    </div>
    <a href="{{ route('invitations.create') }}" class="btn" style="background: white; color: #db2777; height: fit-content; border: none; font-weight: 600;">SEND NEW</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>From Sender</th>
                <th>Colocation Name</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invitations as $invitation)
            <tr>
                <td style="font-weight: 600; color: var(--text);">{{ $invitation->sender->name }}</td>
                <td>{{ $invitation->colocation->name }}</td>
                <td><span class="status-badge" style="background: #fdf2f8; color: #db2777;">{{ $invitation->status }}</span></td>
                <td>{{ $invitation->created_at->diffForHumans() }}</td>
                <td style="display: flex; gap: 0.75rem;">
                    <form action="{{ route('invitations.accept', $invitation->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn" style="background: #ecfdf5; color: #10b981; border: 1px solid #10b981;">ACCEPT</button>
                    </form>
                    <form action="{{ route('invitations.decline', $invitation->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn" style="background: #fef2f2; color: #ef4444; border: 1px solid #ef4444;">DECLINE</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: var(--text-light);">No pending invitations.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
