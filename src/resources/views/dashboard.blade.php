<x-app-layout>
<div class="animate-smooth">

    {{-- Page Header --}}
    <div style="margin-bottom:3.5rem;">
        <div class="page-eyebrow">Command Center</div>
        <h1 class="page-title">Welcome back, <span>{{ auth()->user()->name }}</span></h1>
        <p class="page-subtitle">Here's a live overview of your shared living network.</p>
    </div>

    {{-- Metric Strip --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem; margin-bottom:3.5rem;">
        <div class="stat-box">
            <div class="stat-value">{{ auth()->user()->colocations->count() }}</div>
            <div class="stat-label">Active Spaces</div>
        </div>
        <div class="stat-box" style="border-color:var(--border-bright);">
            <div class="stat-value">
                {{ \App\Models\Invitation::where('receiver_id', auth()->id())->where('status', 'pending')->count() }}
            </div>
            <div class="stat-label">Pending Invites</div>
        </div>
        <div class="stat-box">
            <div class="stat-value" style="color:var(--secondary);">
                {{ number_format(auth()->user()->expenses()->sum('amount'), 0) }}
            </div>
            <div class="stat-label">Lifetime Spend (DH)</div>
        </div>
        <div class="stat-box">
            <div class="stat-value" style="color:var(--accent);">{{ auth()->user()->reputation ?? 0 }}</div>
            <div class="stat-label">Reputation XP</div>
        </div>
    </div>

    {{-- Main 2-col Grid --}}
    <div style="display:grid; grid-template-columns:1fr 360px; gap:2rem;">

        {{-- Left: Hero CTA + Recent Activity --}}
        <div style="display:flex; flex-direction:column; gap:2rem;">

            {{-- Hero Card --}}
            <div class="glass-card" style="position:relative; overflow:hidden; padding:3rem;">
                {{-- Decorative blob --}}
                <div style="position:absolute; top:-60px; right:-60px; width:220px; height:220px; border-radius:50%; background:var(--primary-glow); filter:blur(80px); pointer-events:none;"></div>

                <div style="position:relative; z-index:1;">
                    <p style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.18em; color:var(--primary); margin-bottom:1rem;">Financial Sync</p>
                    <h2 style="font-size:1.9rem; font-weight:900; letter-spacing:-0.04em; color:var(--text-main); margin-bottom:0.75rem; line-height:1.1;">Shared Ledger<br>at a Glance.</h2>
                    <p style="font-size:0.9rem; color:var(--text-muted); margin-bottom:2rem; max-width:420px;">Track expenses, split costs, and settle balances with your co-living community in real time.</p>
                    <div style="display:flex; gap:1rem;">
                        <a href="{{ route('colocations.index') }}" class="btn-premium">View Spaces</a>
                        <a href="{{ route('expenses.index') }}" class="btn-ghost">All Expenses</a>
                    </div>
                </div>

                {{-- Mini chart illustration bars --}}
                <div style="position:absolute; bottom:2rem; right:3rem; display:flex; align-items:flex-end; gap:6px; opacity:0.18;">
                    @foreach([40,65,50,80,60,90,70,55,85,75] as $h)
                        <div style="width:14px; height:{{ $h }}px; background:var(--primary); border-radius:4px 4px 0 0;"></div>
                    @endforeach
                </div>
            </div>

            {{-- Recent Expenses --}}
            <div class="glass-card" style="padding:2rem;">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.75rem;">
                    <h3 style="font-size:1rem; font-weight:800; letter-spacing:-0.02em; color:var(--text-main);">Recent Expenses</h3>
                    <a href="{{ route('expenses.index') }}" style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.14em; color:var(--primary); text-decoration:none; padding-bottom:1px; border-bottom:1px solid var(--primary-dim);">View All</a>
                </div>

                @forelse(auth()->user()->expenses()->with('colocation','category')->latest()->take(6)->get() as $expense)
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:1rem 0; border-bottom:1px solid var(--border-card);">
                        <div style="display:flex; align-items:center; gap:1rem;">
                            <div style="width:40px; height:40px; border-radius:12px; background:var(--bg-elevated); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:0.8rem; font-weight:900; color:var(--accent); flex-shrink:0;">
                                {{ substr($expense->category->name ?? 'G', 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight:800; font-size:0.9rem; color:var(--text-main);">{{ $expense->title }}</div>
                                <div style="font-size:0.65rem; font-weight:700; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em; margin-top:2px;">{{ $expense->colocation->name ?? '—' }}</div>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:1.1rem; font-weight:900; letter-spacing:-0.03em; color:var(--text-main);">{{ number_format($expense->amount, 2) }} <span style="font-size:0.7rem; color:var(--text-dim); font-style:italic;">DH</span></div>
                            <div style="font-size:0.6rem; color:var(--text-dim); font-weight:700; margin-top:2px;">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</div>
                        </div>
                    </div>
                @empty
                    <p style="font-size:0.8rem; color:var(--text-dim); font-style:italic; padding:2rem 0; text-align:center;">No expenses recorded yet.</p>
                @endforelse
            </div>

        </div>

        {{-- Right: Reputation + Shortcuts --}}
        <div style="display:flex; flex-direction:column; gap:2rem;">

            {{-- Trust Score card --}}
            <div class="glass-card" style="padding:2rem;">
                <p style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.18em; color:var(--primary); margin-bottom:1.25rem;">Trust Rating</p>
                <div style="display:flex; align-items:baseline; gap:10px; margin-bottom:1.25rem;">
                    <span style="font-size:3rem; font-weight:900; letter-spacing:-0.06em; color:var(--primary); line-height:1;">{{ auth()->user()->reputation ?? 0 }}</span>
                    <span style="font-size:0.7rem; font-weight:700; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">/ 1000 XP</span>
                </div>
                {{-- Progress bar --}}
                <div style="height:6px; background:rgba(0,0,0,0.25); border-radius:99px; overflow:hidden; margin-bottom:0.75rem;">
                    <div style="height:100%; background:linear-gradient(90deg, var(--primary), var(--secondary)); border-radius:99px; width:{{ min(((auth()->user()->reputation ?? 0)/1000)*100, 100) }}%; transition:width 1s ease;"></div>
                </div>
                <p style="font-size:0.72rem; color:var(--text-muted); line-height:1.6;">Maintain 800+ XP to reach Platinum Member status.</p>
            </div>

            {{-- My Spaces --}}
            <div class="glass-card" style="padding:2rem;">
                <p style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.18em; color:var(--text-dim); margin-bottom:1.25rem;">My Spaces</p>
                @forelse(auth()->user()->colocations()->latest()->take(4)->get() as $col)
                    <a href="{{ route('colocations.show', $col->id) }}"
                       style="display:flex; align-items:center; justify-content:space-between; padding:0.85rem; border-radius:14px; margin-bottom:0.5rem; background:rgba(0,0,0,0.15); border:1px solid var(--border-card); text-decoration:none; transition:border-color 0.25s, background 0.25s;"
                       onmouseover="this.style.background='rgba(255,174,157,0.06)'; this.style.borderColor='var(--border-bright)'"
                       onmouseout="this.style.background='rgba(0,0,0,0.15)'; this.style.borderColor='var(--border-card)'">
                        <span style="font-size:0.85rem; font-weight:800; color:var(--text-main);">{{ $col->name }}</span>
                        <svg style="width:14px;height:14px;color:var(--text-dim);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @empty
                    <p style="font-size:0.8rem; color:var(--text-dim); font-style:italic; text-align:center; padding:1.5rem 0;">No spaces yet.</p>
                @endforelse
            </div>

            {{-- Quick Links --}}
            <div class="glass-card" style="padding:2rem;">
                <p style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.18em; color:var(--text-dim); margin-bottom:1.25rem;">Quick Actions</p>
                <a href="{{ route('profile.edit') }}" style="display:flex; align-items:center; justify-content:space-between; padding:0.85rem; border-radius:14px; margin-bottom:0.5rem; background:rgba(0,0,0,0.15); border:1px solid var(--border-card); text-decoration:none; transition:border-color 0.25s;"
                   onmouseover="this.style.borderColor='var(--border-bright)'" onmouseout="this.style.borderColor='var(--border-card)'">
                    <span style="font-size:0.82rem; font-weight:700; color:var(--text-muted);">Edit Profile</span>
                    <svg style="width:13px;height:13px;color:var(--text-dim);" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('invitations.index') }}" style="display:flex; align-items:center; justify-content:space-between; padding:0.85rem; border-radius:14px; background:rgba(0,0,0,0.15); border:1px solid var(--border-card); text-decoration:none; transition:border-color 0.25s;"
                   onmouseover="this.style.borderColor='var(--border-bright)'" onmouseout="this.style.borderColor='var(--border-card)'">
                    <span style="font-size:0.82rem; font-weight:700; color:var(--text-muted);">View Invitations</span>
                    <svg style="width:13px;height:13px;color:var(--text-dim);" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

        </div>
    </div>

</div>
</x-app-layout>
