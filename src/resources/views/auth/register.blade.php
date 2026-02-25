<x-guest-layout>

    {{-- Title --}}
    <div style="text-align:center; margin-bottom:2.25rem;">
        <h2 style="font-size:1.6rem; font-weight:900; letter-spacing:-0.04em; color:var(--text-main); margin-bottom:0.35rem;">Create your account</h2>
        <p style="font-size:0.82rem; color:var(--text-dim); font-weight:600;">Join EasyColoc and start tracking your shared expenses.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" style="display:flex; flex-direction:column; gap:1.1rem;">
        @csrf

        {{-- Full Name --}}
        <div>
            <label class="field-label" for="name">Full Name</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="modern-input"
                placeholder="Antoine Dupont"
                required
                autofocus
                autocomplete="name">
            @error('name')
                <p style="margin-top:0.5rem; font-size:0.72rem; font-weight:700; color:var(--danger);">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="field-label" for="email">Email address</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="modern-input"
                placeholder="you@example.com"
                required
                autocomplete="username">
            @error('email')
                <p style="margin-top:0.5rem; font-size:0.72rem; font-weight:700; color:var(--danger);">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="field-label" for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                class="modern-input"
                placeholder="Min. 8 characters"
                required
                autocomplete="new-password">
            @error('password')
                <p style="margin-top:0.5rem; font-size:0.72rem; font-weight:700; color:var(--danger);">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label class="field-label" for="password_confirmation">Confirm Password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="modern-input"
                placeholder="Repeat password"
                required
                autocomplete="new-password">
            @error('password_confirmation')
                <p style="margin-top:0.5rem; font-size:0.72rem; font-weight:700; color:var(--danger);">{{ $message }}</p>
            @enderror
        </div>

        {{-- Terms mini-note --}}
        <p style="font-size:0.7rem; color:var(--text-dim); font-weight:600; line-height:1.6;">
            By registering you agree to our fair-use policy. Your data is never sold.
        </p>

        {{-- Submit --}}
        <button type="submit" class="btn-premium" style="width:100%; justify-content:center;">
            Create Account
            <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </button>
    </form>

    {{-- Divider --}}
    <div style="display:flex; align-items:center; gap:1rem; margin:1.75rem 0;">
        <div style="flex:1; height:1px; background:var(--border-card);"></div>
        <span style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.14em; color:var(--text-dim);">Have an account?</span>
        <div style="flex:1; height:1px; background:var(--border-card);"></div>
    </div>

    {{-- Login link --}}
    <a href="{{ route('login') }}"
       class="btn-ghost"
       style="width:100%; text-align:center; justify-content:center; text-decoration:none;">
        Sign in instead
    </a>

</x-guest-layout>
