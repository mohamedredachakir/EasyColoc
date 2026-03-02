@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: auto;">
    <h1 style="margin-top: 0; color: #8b5cf6;">EDIT CATEGORY</h1>
    <p style="color: var(--text-light); margin-bottom: 2rem;">Update your expense category details.</p>
    
    <form action="{{ route('category.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Category Name</label>
            <input type="text" name="name" id="name" placeholder="e.g. Food, Utility, Internet" required value="{{ old('name', $category->name) }}" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border);">
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="colocation_id" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Colocation</label>
            <select name="colocation_id" id="colocation_id" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border);">
                @foreach(\App\Models\Colocation::all() as $coloc)
                    <option value="{{ $coloc->id }}" {{ $category->colocation_id == $coloc->id ? 'selected' : '' }}>{{ $coloc->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn" style="background: #8b5cf6; color: white; flex: 1; padding: 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; border: none;">UPDATE CATEGORY</button>
            <a href="{{ route('category.index') }}" class="btn" style="background: var(--bg); border: 1px solid var(--border); flex: 1; padding: 1rem; text-align: center; border-radius: 0.5rem; text-decoration: none; color: var(--text);">CANCEL</a>
        </div>
    </form>
</div>
@endsection
