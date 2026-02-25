<x-app-layout>

<div style="margin-bottom:2.5rem;" class="animate-smooth">
    <div class="page-eyebrow">Inbox</div>
    <h1 class="page-title">Invitations</h1>
    <p class="page-subtitle">Pending requests to join shared living spaces.</p>
</div>

@if($invitations->isEmpty())
    <div style="padding:5rem 2rem; text-align:center; border:1px dashed var(--border); border-radius:var(--radius-lg);">
        <div style="width:64px; height:64px; border-radius:18px; background:var(--bg-elevated); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; margin:0 auto 1.25rem; opacity:0.6;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:30px;height:30px;color:var(--text-dim);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h3 style="font-size:1.1rem; font-weight:800; color:var(--text-main); margin-bottom:0.4rem;">All caught up!</h3>
        <p style="font-size:0.82rem; color:var(--text-dim);">No pending invitations.</p>
    </div>
@else
    <div style="display:flex; flex-direction:column; gap:0.75rem;">
        @foreach($invitations as $invitation)
            <div class="glass-card animate-smooth" style="display:flex; align-items:center; justify-content:space-between; padding:1.25rem 1.75rem; flex-wrap:wrap; gap:1rem;">

                {{-- Sender info --}}
                <div style="display:flex; align-items:center; gap:1rem; flex:1; min-width:200px;">
                    <div style="width:44px; height:44px; border-radius:12px; background:var(--primary-dim); border:1px solid var(--border-bright); display:flex; align-items:center; justify-content:center; font-size:1rem; font-weight:900; color:var(--primary); flex-shrink:0;">
                        {{ strtoupper(substr($invitation->sender->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:0.9rem; font-weight:800; color:var(--text-main); margin-bottom:3px;">
                            {{ $invitation->sender->name }}
                            <span style="font-size:0.72rem; font-weight:600; color:var(--text-dim); margin-left:4px;">invited you to</span>
                        </div>
                        <div style="font-size:0.85rem; font-weight:800; color:var(--primary);">{{ $invitation->colocation->name }}</div>
                    </div>
                </div>

                {{-- Date + badge --}}
                <div style="display:flex; align-items:center; gap:1rem; flex-shrink:0;">
                    <span class="badge badge-warm">pending</span>
                    <span style="font-size:0.7rem; color:var(--text-dim); font-weight:600;">{{ $invitation->created_at->diffForHumans() }}</span>
                </div>

                {{-- Actions --}}
                <div style="display:flex; gap:0.6rem; flex-shrink:0;">
                    <form action="{{ route('invitations.accept', $invitation->id) }}" method="POST">
                        @csrf
                        <button class="btn-premium" style="padding:0.55rem 1.25rem; font-size:0.8rem;">Accept</button>
                    </form>
                    <form action="{{ route('invitations.refuse', $invitation->id) }}" method="POST">
                        @csrf
                        <button class="btn-ghost" style="padding:0.55rem 1.25rem; font-size:0.8rem; color:var(--danger); border-color:rgba(221,128,128,0.25);">Decline</button>
                    </form>
                </div>

            </div>
        @endforeach
    </div>
@endif

</x-app-layout>
