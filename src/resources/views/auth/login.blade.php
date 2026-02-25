<x-guest-layout>

    {{-- Title --}}
    <div style="text-align:center; margin-bottom:2.25rem;">
        <h2 style="font-size:1.6rem; font-weight:900; letter-spacing:-0.04em; color:var(--text-main); margin-bottom:0.35rem;">Welcome back</h2>
        <p style="font-size:0.82rem; color:var(--text-dim); font-weight:600;">Sign in to manage your shared expenses.</p>
    </div>

    {{-- Session Status (e.g. after password reset) --}}
    @if (session('status'))
        <div style="margin-bottom:1.25rem; padding:0.9rem 1.2rem; background:rgba(168,197,160,0.1); border:1px solid rgba(168,197,160,0.25); border-radius:12px; color:var(--success); font-size:0.8rem; font-weight:700;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" style="display:flex; flex-direction:column; gap:1.1rem;">
        @csrf

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
                autofocus
                autocomplete="username">
            @error('email')
                <p style="margin-top:0.5rem; font-size:0.72rem; font-weight:700; color:var(--danger);">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.6rem;">
                <label class="field-label" for="password" style="margin-bottom:0;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.1em; color:var(--primary); text-decoration:none; opacity:0.8;"
                       onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input
                id="password"
                type="password"
                name="password"
                class="modern-input"
                placeholder="••••••••"
                required
                autocomplete="current-password">
            @error('password')
                <p style="margin-top:0.5rem; font-size:0.72rem; font-weight:700; color:var(--danger);">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <label style="display:flex; align-items:center; gap:10px; cursor:pointer; user-select:none;">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                style="width:17px; height:17px; border-radius:5px; border:1px solid var(--border); background:rgba(0,0,0,0.25); accent-color:var(--primary); cursor:pointer;">
            <span style="font-size:0.8rem; font-weight:600; color:var(--text-muted);">Remember me for 30 days</span>
        </label>

        {{-- Submit --}}
        <button type="submit" class="btn-premium" style="width:100%; margin-top:0.5rem; justify-content:center;">
            Sign In
            <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </button>
    </form>

    {{-- Divider --}}
    <div style="display:flex; align-items:center; gap:1rem; margin:1.75rem 0;">
        <div style="flex:1; height:1px; background:var(--border-card);"></div>
        <span style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.14em; color:var(--text-dim);">New here?</span>
        <div style="flex:1; height:1px; background:var(--border-card);"></div>
    </div>

    {{-- Register link --}}
    @if (Route::has('register'))
        <a href="{{ route('register') }}"
           class="btn-ghost"
           style="width:100%; text-align:center; justify-content:center; text-decoration:none;">
            Create a free account
        </a>
    @endif

</x-guest-layout>
