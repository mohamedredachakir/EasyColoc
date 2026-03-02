@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">📂 Categories</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Organize your expenses into meaningful groups.</p>
    </div>
    <a href="{{ route('category.create') }}" class="btn" style="background: white; color: #7c3aed; height: fit-content; border: none; font-weight: 600;">NEW CATEGORY</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Colocation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td style="font-weight: 600; color: var(--text);">{{ $category->name }}</td>
                <td>{{ $category->colocation->name ?? 'Global' }}</td>
                <td style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('category.show', $category->id) }}" class="btn" style="background: var(--bg); color: var(--text-light); border: 1px solid var(--border);">VIEW</a>
                    <a href="{{ route('category.edit', $category->id) }}" class="btn" style="background: var(--bg); color: var(--text-light); border: 1px solid var(--border);">EDIT</a>
                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background: #fef2f2; color: var(--danger); border: 1px solid #fee2e2;">DELETE</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center; color: var(--text-light);">No categories found. Create one!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
