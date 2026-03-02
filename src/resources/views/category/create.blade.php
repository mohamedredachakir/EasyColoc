@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: auto;">
    <h1 style="margin-top: 0; color: #8b5cf6;">NEW CATEGORY</h1>
    <p style="color: var(--text-light); margin-bottom: 2rem;">Group your bills and household costs by category.</p>
    
    <form action="{{ route('category.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" placeholder="e.g. Food, Utility, Internet" required>
        </div>

        <div class="form-group">
            <label for="colocation_id">Colocation</label>
            <select name="colocation_id" id="colocation_id" required>
                @foreach(\App\Models\Colocation::all() as $coloc)
                    <option value="{{ $coloc->id }}">{{ $coloc->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn" style="background: #8b5cf6; color: white; flex: 1; padding: 1rem;">CREATE CATEGORY</button>
            <a href="{{ route('category.index') }}" class="btn" style="background: var(--bg); border: 1px solid var(--border); padding: 1rem;">CANCEL</a>
        </div>
    </form>
</div>
@endsection
