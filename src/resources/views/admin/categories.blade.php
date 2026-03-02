@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #8b5cf6 0%, #4c1d95 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">🏷️ Categories Management</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Manage expense categories.</p>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td style="font-weight: 600;">{{ $category->name }}</td>
                <td>{{ $category->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
