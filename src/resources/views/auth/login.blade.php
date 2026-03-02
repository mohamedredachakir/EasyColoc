@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 400px; margin: 4rem auto;">
    <h1 style="text-align: center; color: var(--primary);">Welcome Back</h1>
    <p style="text-align: center; color: var(--text-light); margin-bottom: 2rem;">Log in to manage your colocations.</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; margin-top: 1rem;">LOG IN</button>
    </form>
    
    <p style="text-align: center; margin-top: 1.5rem; color: var(--text-light);">
        New here? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 600;">Sign up</a>
    </p>
</div>
@endsection
