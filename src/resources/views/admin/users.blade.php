@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #1f2937 0%, #111827 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">👥 User Management</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Total users registered in the platform.</p>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Reputation</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td style="font-weight: 600;">{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="status-badge" style="background: #e0e7ff; color: #4338ca;">{{ $user->role }}</span>
                </td>
                <td>⭐ {{ $user->reputation }}</td>
                <td>
                    @if($user->is_ban)
                        <span class="status-badge" style="background: #fee2e2; color: #b91c1c;">Banned</span>
                    @else
                        <span class="status-badge" style="background: #dcfce7; color: #15803d;">Active</span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    @if(!$user->is_ban)
                        <form action="{{ route('admin.ban', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to ban this user?')">
                            @csrf
                            <button type="submit" class="btn" style="background: #fef2f2; color: #ef4444; border: 1px solid #ef4444; padding: 0.25rem 0.5rem; font-size: 0.875rem;">BAN</button>
                        </form>
                    @else
                        <form action="{{ route('admin.unban', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn" style="background: #ecfdf5; color: #10b981; border: 1px solid #10b981; padding: 0.25rem 0.5rem; font-size: 0.875rem;">UNBAN</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
