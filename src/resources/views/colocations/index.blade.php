<x-app-layout>

{{-- ── Page Header ── --}}
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2.5rem;">
    <div>
        <div class="page-eyebrow">My Spaces</div>
        <h1 class="page-title">Living Spaces</h1>
        <p class="page-subtitle">Manage your shared housing groups and track expenses together.</p>
    </div>
    <button onclick="ui.openModal('createColocationModal')" class="btn-premium">
        <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
        </svg>
        New Space
    </button>
</div>

{{-- ── Space Grid ── --}}
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:1.25rem;">
    @forelse($colocations as $colocation)

        <div class="glass-card animate-smooth" style="display:flex; flex-direction:column; gap:1.5rem; position:relative; overflow:hidden;">

            {{-- Decorative top stripe --}}
            <div style="position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg, var(--primary), var(--secondary)); border-radius:var(--radius-lg) var(--radius-lg) 0 0;"></div>

            {{-- Header row --}}
            <div style="display:flex; align-items:flex-start; justify-content:space-between; padding-top:0.5rem;">
                <div style="width:48px; height:48px; border-radius:14px; background:var(--primary-dim); display:flex; align-items:center; justify-content:center; border:1px solid var(--border-bright);">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:var(--primary);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <span class="badge badge-warm">{{ $colocation->status->value ?? 'active' }}</span>
            </div>

            {{-- Name --}}
            <div>
                <h2 style="font-size:1.25rem; font-weight:900; letter-spacing:-0.03em; color:var(--text-main); margin-bottom:0.3rem;">{{ $colocation->name }}</h2>
                <p style="font-size:0.75rem; color:var(--text-dim); font-weight:600;">Created {{ $colocation->created_at->diffForHumans() }}</p>
            </div>

            {{-- Members row --}}
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="display:flex;">
                    @foreach($colocation->users->take(4) as $user)
                        <div style="width:30px; height:30px; border-radius:8px; background:var(--bg-elevated); border:2px solid var(--bg-surface); display:flex; align-items:center; justify-content:center; font-size:0.65rem; font-weight:900; color:var(--text-muted); margin-right:-8px;" title="{{ $user->name }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endforeach
                </div>
                <span style="font-size:0.7rem; font-weight:700; color:var(--text-dim); padding-left:0.75rem; margin-left:4px; border-left:1px solid var(--border);">
                    {{ $colocation->users->count() }} {{ Str::plural('member', $colocation->users->count()) }}
                </span>
            </div>

            {{-- Footer: Total + CTA --}}
            <div style="display:flex; align-items:center; justify-content:space-between; padding-top:1rem; border-top:1px solid var(--border-card);">
                <div>
                    <div style="font-size:0.6rem; font-weight:800; text-transform:uppercase; letter-spacing:0.14em; color:var(--text-dim); margin-bottom:0.25rem;">Total Expenses</div>
                    <div style="font-size:1.4rem; font-weight:900; letter-spacing:-0.04em; color:var(--text-main);">
                        {{ number_format($colocation->expenses->sum('amount'), 0) }}
                        <span style="font-size:0.7rem; color:var(--primary); font-weight:700;">DH</span>
                    </div>
                </div>
                <a href="{{ route('colocations.show', $colocation->id) }}" class="btn-premium" style="padding:0.6rem 1.2rem; font-size:0.8rem;">
                    Open →
                </a>
            </div>

        </div>

    @empty
        {{-- Empty state --}}
        <div style="grid-column:1/-1; padding:5rem 2rem; text-align:center; border:1px dashed var(--border); border-radius:var(--radius-lg);">
            <div style="width:72px; height:72px; border-radius:20px; background:var(--bg-elevated); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; margin:0 auto 1.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:36px;height:36px;color:var(--text-dim);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 style="font-size:1.25rem; font-weight:800; color:var(--text-main); margin-bottom:0.5rem;">No spaces yet</h3>
            <p style="font-size:0.9rem; color:var(--text-dim); margin-bottom:2rem;">Create your first shared living space to start tracking expenses.</p>
            <button onclick="ui.openModal('createColocationModal')" class="btn-premium">Create a Space</button>
        </div>
    @endforelse
</div>

{{-- ── Create Space Modal ── --}}
<div id="createColocationModal" class="modal-overlay-v3">
    <div class="modal-content-v3">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem;">
            <div>
                <div class="page-eyebrow" style="margin-bottom:0.5rem;">New Space</div>
                <h2 class="modal-title">Create a Living Space</h2>
            </div>
            <button onclick="ui.closeModal('createColocationModal')" class="modal-close">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('colocations.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:1.5rem;">
                <label class="field-label">Space Name</label>
                <input type="text" name="name" class="modern-input" placeholder="e.g. Apartment Casablanca" required autofocus>
            </div>
            <div style="display:flex; gap:1rem; margin-top:2rem;">
                <button type="submit" class="btn-premium" style="flex:1;">Create Space</button>
                <button type="button" onclick="ui.closeModal('createColocationModal')" class="btn-ghost">Cancel</button>
            </div>
        </form>
    </div>
</div>

</x-app-layout>
