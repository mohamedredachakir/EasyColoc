@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #ec4899 0%, #9d174d 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">✉️ All Invitations</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Monitor all invitations sent within the system.</p>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Colocation</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invitations as $invitation)
            <tr>
                <td>{{ $invitation->id }}</td>
                <td>{{ $invitation->sender->name }}</td>
                <td>{{ $invitation->receiver->name }}</td>
                <td>{{ $invitation->colocation->name }}</td>
                <td>
                    <span class="status-badge" style="background: #fdf2f8; color: #db2777;">{{ $invitation->status }}</span>
                </td>
                <td>{{ $invitation->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
