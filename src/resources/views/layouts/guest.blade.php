<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EasyColoc') }}</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:2.5rem 1.5rem; position:relative; overflow:hidden;">

    {{-- Ambient background blobs --}}
    <div style="position:fixed; top:-140px; left:-140px; width:480px; height:480px; border-radius:50%; background:var(--primary-glow); filter:blur(130px); pointer-events:none; z-index:0; opacity:0.7;"></div>
    <div style="position:fixed; bottom:-100px; right:-100px; width:360px; height:360px; border-radius:50%; background:rgba(179,145,136,0.07); filter:blur(110px); pointer-events:none; z-index:0;"></div>

    {{-- Back to home link --}}
    <a href="{{ url('/') }}"
       style="position:fixed; top:2rem; left:2rem; display:inline-flex; align-items:center; gap:8px; padding:0.55rem 1rem; background:rgba(255,174,157,0.08); border:1px solid rgba(255,174,157,0.15); border-radius:12px; color:var(--primary); font-size:0.72rem; font-weight:800; text-transform:uppercase; letter-spacing:0.12em; text-decoration:none; z-index:10; transition:all 0.2s;"
       onmouseover="this.style.background='rgba(255,174,157,0.15)'"
       onmouseout="this.style.background='rgba(255,174,157,0.08)'">
        <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Home
    </a>

    <div style="position:relative; z-index:1; width:100%; max-width:450px;">
        {{-- Logo --}}
        <a href="{{ url('/') }}" style="display:flex; align-items:center; justify-content:center; gap:14px; margin-bottom:2.75rem; text-decoration:none; transition:opacity 0.2s;"
           onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            <div class="logo-mark" style="width:48px; height:48px; border-radius:16px;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <polyline points="9 22 9 12 15 12 15 22" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="logo-name" style="font-size:1.6rem;">EasyColoc<span>.</span></div>
        </a>

        {{-- Auth Card --}}
        <div class="glass-card" style="border-radius:var(--radius-xl); padding:2.75rem; transition:none !important; transform:none !important;">
            {{ $slot }}
        </div>
    </div>

</body>
</html>
