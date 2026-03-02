@extends('layouts.app')

@section('content')
<div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 2.5rem; background: linear-gradient(135deg, var(--primary) 0%, #4f46e5 100%); color: white; border: none;">
    <div>
        <h1 style="margin: 0; font-size: 2.25rem;">🏠 Edit Colocation</h1>
        <p style="opacity: 0.9; font-size: 1.125rem; margin-top: 0.5rem;">Update your household details.</p>
    </div>
</div>

<div class="card" style="max-width: 600px; margin: 2rem auto;">
    <form action="{{ route('colocation.update', $colocation->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group" style="margin-bottom: 2rem;">
            <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Colocation Name</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $colocation->name) }}" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border);">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center;">UPDATE COLOCATION</button>
            <a href="{{ route('colocation.show', $colocation->id) }}" class="btn" style="flex: 1; justify-content: center; background: var(--bg); border: 1px solid var(--border);">CANCEL</a>
        </div>
    </form>
</div>
@endsection
