@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: auto;">
    <h1 style="margin-top: 0; color: var(--primary);">CREATE NEW COLOCATION</h1>
    <p style="color: var(--text-light); margin-bottom: 2rem;">Start a new shared household and invite your friends.</p>
    
    <form action="{{ route('colocation.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Colocation Name</label>
            <input type="text" name="name" id="name" placeholder="e.g. My Awesome Home 🏠" required>
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 1rem;">CREATE & JOIN</button>
            <a href="{{ route('colocation.index') }}" class="btn" style="background: var(--bg); border: 1px solid var(--border); padding: 1rem;">CANCEL</a>
        </div>
    </form>
</div>
@endsection
