@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 480px; margin: 4rem auto;">
    <h1 style="text-align: center; color: var(--primary);">Join the Club</h1>
    <p style="text-align: center; color: var(--text-light); margin-bottom: 2rem;">Start splitting expenses easily.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required autofocus>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required autocomplete="new-password">
            </div>
            <div>
                <label for="password_confirmation">Confirm</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; margin-top: 1.5rem;">CREATE ACCOUNT</button>
    </form>
    
    <p style="text-align: center; margin-top: 1.5rem; color: var(--text-light);">
        Already have an account? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 600;">Sign in</a>
    </p>
</div>
@endsection
