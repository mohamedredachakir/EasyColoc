@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #059669 0%, #064e3b 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">🏠 Colocations Management</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Total colocations created in the platform.</p>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Owner</th>
                <th>Members Count</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($colocations as $colocation)
            <tr>
                <td>{{ $colocation->id }}</td>
                <td style="font-weight: 600;">{{ $colocation->name }}</td>
                <td>{{ $colocation->owner_id }}</td>
                <td>{{ $colocation->users()->count() }}</td>
                <td><span class="status-badge status-active">{{ $colocation->status }}</span></td>
                <td>{{ $colocation->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
