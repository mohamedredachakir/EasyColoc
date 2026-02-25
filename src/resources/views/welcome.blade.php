<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyColoc — Shared Living, Simplified</title>
    <meta name="description" content="Track shared expenses, settle balances, and live in harmony with your housemates. EasyColoc makes colocation finances effortless.">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        /* Landing-page-only overrides */
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        @media (max-width: 860px) {
            .hero-grid { grid-template-columns: 1fr; }
            .hero-visual { display: none; }
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
        }
        @media (max-width: 860px) {
            .feature-grid { grid-template-columns: 1fr; }
        }
        .nav-landing {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 4rem;
            border-bottom: 1px solid rgba(204,174,164,0.08);
            position: sticky;
            top: 0;
            background: rgba(30,24,22,0.92);
            backdrop-filter: blur(16px);
            z-index: 100;
        }
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
        }
        .trust-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 3rem;
            padding: 1.5rem 2rem;
            border-top: 1px solid rgba(204,174,164,0.06);
            border-bottom: 1px solid rgba(204,174,164,0.06);
        }
    </style>
</head>
<body style="font-family:'Plus Jakarta Sans',sans-serif; background:#1e1816; color:#FAF2EA; min-height:100vh; -webkit-font-smoothing:antialiased;">

<!-- ══════════ NAVBAR ══════════ -->
<nav class="nav-landing">
    <!-- Logo -->
    <div style="display:flex; align-items:center; gap:14px; text-decoration:none;">
        <div style="width:40px; height:40px; border-radius:12px; background:#FFAE9D; display:flex; align-items:center; justify-content:center; box-shadow:0 6px 20px rgba(255,174,157,0.3);">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke="#1e1816" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <polyline points="9 22 9 12 15 12 15 22" stroke="#1e1816" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <span style="font-size:1.25rem; font-weight:900; letter-spacing:-0.04em; color:#FAF2EA;">EasyColoc<span style="color:#FFAE9D;">.</span></span>
    </div>

    <!-- Nav links -->
    <div style="display:flex; align-items:center; gap:0.75rem;">
        @auth
            <a href="{{ route('dashboard') }}"
               style="display:inline-flex; align-items:center; gap:8px; padding:0.65rem 1.35rem; background:rgba(255,174,157,0.1); color:#FFAE9D; font-size:0.85rem; font-weight:800; border:1px solid rgba(255,174,157,0.22); border-radius:12px; text-decoration:none; transition:all 0.2s;"
               onmouseover="this.style.background='rgba(255,174,157,0.18)'"
               onmouseout="this.style.background='rgba(255,174,157,0.1)'">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}"
               style="display:inline-flex; align-items:center; padding:0.65rem 1.35rem; background:transparent; color:#CCAEA4; font-size:0.85rem; font-weight:700; border:1px solid rgba(204,174,164,0.18); border-radius:12px; text-decoration:none; transition:all 0.2s;"
               onmouseover="this.style.background='rgba(204,174,164,0.06)'; this.style.borderColor='rgba(204,174,164,0.35)'"
               onmouseout="this.style.background='transparent'; this.style.borderColor='rgba(204,174,164,0.18)'">
                Sign In
            </a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}"
               style="display:inline-flex; align-items:center; gap:8px; padding:0.65rem 1.35rem; background:#FFAE9D; color:#1e1816; font-size:0.85rem; font-weight:800; border:none; border-radius:12px; text-decoration:none; box-shadow:0 4px 16px rgba(255,174,157,0.28); transition:all 0.2s;"
               onmouseover="this.style.filter='brightness(1.07)'; this.style.transform='translateY(-1px)'"
               onmouseout="this.style.filter=''; this.style.transform=''">
                Get Started — Free
            </a>
            @endif
        @endauth
    </div>
</nav>

<!-- ══════════ HERO ══════════ -->
<section style="position:relative; padding:7rem 4rem 5rem; overflow:hidden; max-width:1300px; margin:0 auto;">
    <!-- Background blobs -->
    <div class="blob" style="top:-80px; left:-120px; width:500px; height:500px; background:rgba(255,174,157,0.1); z-index:0;"></div>
    <div class="blob" style="bottom:-100px; right:-80px; width:400px; height:400px; background:rgba(179,145,136,0.06); z-index:0;"></div>

    <div class="hero-grid" style="position:relative; z-index:1;">
        <!-- Text -->
        <div>
            <div style="display:inline-flex; align-items:center; gap:10px; padding:6px 16px; background:rgba(255,174,157,0.1); border:1px solid rgba(255,174,157,0.2); border-radius:99px; margin-bottom:2rem;">
                <span style="width:7px; height:7px; border-radius:50%; background:#FFAE9D; display:inline-block; animation:pulse 2s ease-in-out infinite;"></span>
                <span style="font-size:0.7rem; font-weight:800; text-transform:uppercase; letter-spacing:0.15em; color:#FFAE9D;">Shared Living Platform</span>
            </div>

            <h1 style="font-size:clamp(2.8rem,5.5vw,4.25rem); font-weight:900; letter-spacing:-0.05em; line-height:1.0; color:#FAF2EA; margin-bottom:1.5rem;">
                Flat-share finances,<br>
                <span style="color:#FFAE9D;">finally sorted.</span>
            </h1>

            <p style="font-size:1.1rem; font-weight:500; color:#CCAEA4; line-height:1.7; max-width:460px; margin-bottom:2.5rem;">
                Track split expenses, settle IOUs, and keep every housemate in the loop — all in one beautiful, simple tool.
            </p>

            <div style="display:flex; gap:1rem; flex-wrap:wrap;">
                @auth
                    <a href="{{ route('colocations.index') }}"
                       style="display:inline-flex; align-items:center; gap:10px; padding:1rem 2rem; background:#FFAE9D; color:#1e1816; font-size:0.9rem; font-weight:800; border-radius:16px; text-decoration:none; box-shadow:0 8px 28px rgba(255,174,157,0.3); transition:all 0.25s;"
                       onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 14px 40px rgba(255,174,157,0.38)'"
                       onmouseout="this.style.transform=''; this.style.boxShadow='0 8px 28px rgba(255,174,157,0.3)'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        My Spaces
                    </a>
                    <a href="{{ route('dashboard') }}"
                       style="display:inline-flex; align-items:center; gap:10px; padding:1rem 2rem; background:transparent; color:#CCAEA4; font-size:0.9rem; font-weight:700; border:1px solid rgba(204,174,164,0.2); border-radius:16px; text-decoration:none; transition:all 0.25s;"
                       onmouseover="this.style.background='rgba(204,174,164,0.06)'; this.style.borderColor='rgba(204,174,164,0.4)'"
                       onmouseout="this.style.background='transparent'; this.style.borderColor='rgba(204,174,164,0.2)'">
                        Dashboard →
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       style="display:inline-flex; align-items:center; gap:10px; padding:1rem 2rem; background:#FFAE9D; color:#1e1816; font-size:0.9rem; font-weight:800; border-radius:16px; text-decoration:none; box-shadow:0 8px 28px rgba(255,174,157,0.3); transition:all 0.25s;"
                       onmouseover="this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.transform=''">
                        Start for free
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('login') }}"
                       style="display:inline-flex; align-items:center; gap:10px; padding:1rem 2rem; background:transparent; color:#CCAEA4; font-size:0.9rem; font-weight:700; border:1px solid rgba(204,174,164,0.2); border-radius:16px; text-decoration:none; transition:all 0.25s;"
                       onmouseover="this.style.background='rgba(204,174,164,0.06)'; this.style.borderColor='rgba(204,174,164,0.4)'"
                       onmouseout="this.style.background='transparent'; this.style.borderColor='rgba(204,174,164,0.2)'">
                        Sign in
                    </a>
                @endauth
            </div>

            <!-- Trust micro-text -->
            <p style="margin-top:1.5rem; font-size:0.72rem; font-weight:700; color:#7a6560; text-transform:uppercase; letter-spacing:0.1em;">
                No credit card · Free forever for small groups
            </p>
        </div>

        <!-- Visual: mock card -->
        <div class="hero-visual" style="position:relative;">
            <!-- Main mock card -->
            <div style="background:#251f1d; border:1px solid rgba(204,174,164,0.1); border-radius:28px; padding:2rem; box-shadow:0 32px 80px rgba(0,0,0,0.55);">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
                    <div>
                        <div style="font-size:0.6rem; font-weight:800; text-transform:uppercase; letter-spacing:0.15em; color:#FFAE9D; margin-bottom:0.4rem;">Appartement Lyon</div>
                        <div style="font-size:1.3rem; font-weight:900; letter-spacing:-0.04em; color:#FAF2EA;">3 Members</div>
                    </div>
                    <span style="padding:5px 14px; background:rgba(168,197,160,0.1); color:#a8c5a0; border:1px solid rgba(168,197,160,0.2); border-radius:99px; font-size:0.6rem; font-weight:800; text-transform:uppercase; letter-spacing:0.1em;">Settled</span>
                </div>
                <!-- Members -->
                @foreach([['A', '#FFAE9D', 'Antoine', '+120'], ['S', '#CCAEA4', 'Sophie', '-45'], ['M', '#B39188', 'Marc', '-75']] as [$init, $col, $name, $bal])
                <div style="display:flex; align-items:center; justify-content:space-between; padding:0.85rem 1rem; border-radius:12px; background:rgba(0,0,0,0.15); margin-bottom:0.5rem;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div style="width:34px; height:34px; border-radius:10px; background:{{ $col }}20; border:1px solid {{ $col }}30; display:flex; align-items:center; justify-content:center; font-size:0.78rem; font-weight:900; color:{{ $col }};">{{ $init }}</div>
                        <span style="font-size:0.88rem; font-weight:700; color:#FAF2EA;">{{ $name }}</span>
                    </div>
                    <span style="font-size:0.95rem; font-weight:900; color:{{ str_starts_with($bal, '+') ? '#a8c5a0' : '#dd8080' }};">{{ $bal }} DH</span>
                </div>
                @endforeach
                <!-- Recent expense -->
                <div style="margin-top:1.25rem; padding-top:1.25rem; border-top:1px solid rgba(204,174,164,0.07);">
                    <div style="font-size:0.6rem; font-weight:800; text-transform:uppercase; letter-spacing:0.15em; color:#7a6560; margin-bottom:0.75rem;">Latest Expense</div>
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:34px; height:34px; border-radius:10px; background:rgba(255,174,157,0.1); display:flex; align-items:center; justify-content:center; font-size:0.9rem;">🛒</div>
                            <div>
                                <div style="font-size:0.85rem; font-weight:800; color:#FAF2EA;">Courses Carrefour</div>
                                <div style="font-size:0.68rem; color:#7a6560; font-weight:600;">Paid by Antoine · 5 Feb</div>
                            </div>
                        </div>
                        <span style="font-size:1.05rem; font-weight:900; letter-spacing:-0.03em; color:#FAF2EA;">240 DH</span>
                    </div>
                </div>
            </div>
            <!-- Floating badge -->
            <div style="position:absolute; top:-18px; right:-18px; padding:0.7rem 1.1rem; background:#FFAE9D; border-radius:14px; box-shadow:0 8px 24px rgba(255,174,157,0.4); animation:floatBadge 3s ease-in-out infinite;">
                <div style="font-size:0.6rem; font-weight:800; text-transform:uppercase; letter-spacing:0.12em; color:#1e1816;">Split amount</div>
                <div style="font-size:1.2rem; font-weight:900; letter-spacing:-0.04em; color:#1e1816;">80 DH / each</div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════ TRUST BAR ══════════ -->
<div class="trust-bar">
    @foreach(['⚡ Real-time balances', '🔒 Secure & private', '📱 Works on any device', '🤝 Up to 20 members', '✅ Zero maths needed'] as $item)
        <span style="font-size:0.75rem; font-weight:700; color:#7a6560; white-space:nowrap;">{{ $item }}</span>
    @endforeach
</div>

<!-- ══════════ FEATURES ══════════ -->
<section style="padding:6rem 4rem; max-width:1300px; margin:0 auto;">
    <div style="text-align:center; margin-bottom:4rem;">
        <div style="display:inline-flex; align-items:center; gap:10px; font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.2em; color:#FFAE9D; margin-bottom:1rem;">
            <span style="display:block; width:20px; height:2px; background:#FFAE9D; border-radius:2px;"></span>
            Features
            <span style="display:block; width:20px; height:2px; background:#FFAE9D; border-radius:2px;"></span>
        </div>
        <h2 style="font-size:clamp(2rem,4vw,3rem); font-weight:900; letter-spacing:-0.04em; color:#FAF2EA; margin-bottom:1rem;">Everything your flat-share needs</h2>
        <p style="font-size:0.95rem; font-weight:500; color:#CCAEA4; max-width:440px; margin:0 auto;">From the first shared grocery run to final move-out, every dirham tracked — automatically.</p>
    </div>

    <div class="feature-grid">
        @foreach([
            ['💸', 'Smart Expense Splitting', 'Add any shared cost and EasyColoc divides it fairly. Supports unequal splits and custom categories.'],
            ['⚖️', 'Live Balance Sheet', 'See instantly who owes what. Colour-coded balance indicators make debts impossible to miss.'],
            ['✅', 'One-tap Settlement', 'Record payments in one click. Balances update immediately — no spreadsheet drama.'],
            ['📨', 'Space Invitations', 'Invite housemates by email. They accept, and they\'re in — no account linking hassle.'],
            ['📂', 'Custom Categories', 'Rent, utilities, groceries, fun — organise spending however makes sense for your group.'],
            ['📊', 'Dashboard Overview', 'Total spend, your share, number of spaces — see everything at a glance from one place.'],
        ] as [$icon, $title, $desc])
        <div style="background:#251f1d; border:1px solid rgba(204,174,164,0.08); border-radius:24px; padding:2rem; position:relative; overflow:hidden; transition:border-color 0.25s, transform 0.25s, box-shadow 0.25s;"
             onmouseover="this.style.borderColor='rgba(255,174,157,0.2)'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 50px rgba(0,0,0,0.4)'"
             onmouseout="this.style.borderColor='rgba(204,174,164,0.08)'; this.style.transform=''; this.style.boxShadow=''">
            <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#FFAE9D,#B39188); opacity:0; transition:opacity 0.25s;" class="feat-accent"></div>
            <div style="font-size:2rem; margin-bottom:1.25rem;">{{ $icon }}</div>
            <h3 style="font-size:1rem; font-weight:800; color:#FAF2EA; letter-spacing:-0.02em; margin-bottom:0.6rem;">{{ $title }}</h3>
            <p style="font-size:0.82rem; color:#CCAEA4; line-height:1.7; font-weight:500;">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</section>

<!-- ══════════ CTA STRIP ══════════ -->
<section style="padding:5rem 4rem; text-align:center; position:relative; overflow:hidden;">
    <div class="blob" style="top:50%; left:50%; transform:translate(-50%,-50%); width:600px; height:300px; background:rgba(255,174,157,0.06); z-index:0;"></div>
    <div style="position:relative; z-index:1;">
        <h2 style="font-size:clamp(2rem,4vw,3rem); font-weight:900; letter-spacing:-0.04em; color:#FAF2EA; margin-bottom:1rem;">Ready to end the money drama?</h2>
        <p style="font-size:0.95rem; color:#CCAEA4; margin-bottom:2.5rem;">Join in seconds. No payment required.</p>
        <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
            @auth
                <a href="{{ route('colocations.index') }}"
                   style="display:inline-flex; align-items:center; gap:10px; padding:1.1rem 2.5rem; background:#FFAE9D; color:#1e1816; font-size:0.95rem; font-weight:800; border-radius:18px; text-decoration:none; box-shadow:0 8px 28px rgba(255,174,157,0.3); transition:all 0.25s;"
                   onmouseover="this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.transform=''">
                    Go to My Spaces →
                </a>
            @else
                <a href="{{ route('register') }}"
                   style="display:inline-flex; align-items:center; gap:10px; padding:1.1rem 2.5rem; background:#FFAE9D; color:#1e1816; font-size:0.95rem; font-weight:800; border-radius:18px; text-decoration:none; box-shadow:0 8px 28px rgba(255,174,157,0.3); transition:all 0.25s;"
                   onmouseover="this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.transform=''">
                    Create free account →
                </a>
                <a href="{{ route('login') }}"
                   style="display:inline-flex; align-items:center; padding:1.1rem 2.5rem; background:transparent; color:#CCAEA4; font-size:0.95rem; font-weight:700; border:1px solid rgba(204,174,164,0.2); border-radius:18px; text-decoration:none; transition:all 0.25s;"
                   onmouseover="this.style.background='rgba(204,174,164,0.06)'"
                   onmouseout="this.style.background='transparent'">
                    Sign in
                </a>
            @endauth
        </div>
    </div>
</section>

<!-- ══════════ FOOTER ══════════ -->
<footer style="padding:2rem 4rem; border-top:1px solid rgba(204,174,164,0.06); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
    <span style="font-size:0.75rem; color:#7a6560; font-weight:600;">© {{ date('Y') }} EasyColoc — Made with ❤️ for housemates everywhere.</span>
    <div style="display:flex; gap:1.5rem;">
        @if(Route::has('login'))
            <a href="{{ route('login') }}" style="font-size:0.72rem; color:#7a6560; font-weight:700; text-decoration:none;" onmouseover="this.style.color='#CCAEA4'" onmouseout="this.style.color='#7a6560'">Sign in</a>
        @endif
        @if(Route::has('register'))
            <a href="{{ route('register') }}" style="font-size:0.72rem; color:#7a6560; font-weight:700; text-decoration:none;" onmouseover="this.style.color='#CCAEA4'" onmouseout="this.style.color='#7a6560'">Register</a>
        @endif
    </div>
</footer>

<style>
@keyframes floatBadge {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}
@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.85); }
}
</style>

</body>
</html>
