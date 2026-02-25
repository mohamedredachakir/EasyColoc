<x-app-layout>

{{-- ── Breadcrumb + Header ── --}}
<div style="margin-bottom:2.5rem;" class="animate-smooth">
    {{-- Breadcrumb --}}
    <div style="display:flex; align-items:center; gap:8px; font-size:0.72rem; font-weight:700; margin-bottom:1.25rem;">
        <a href="{{ route('colocations.index') }}" style="color:var(--primary); text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Living Spaces</a>
        <svg style="width:12px;height:12px;color:var(--text-dim);" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
        <span style="color:var(--text-dim);">{{ $colocation->name }}</span>
    </div>

    {{-- Title Row --}}
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
        <div>
            <h1 style="font-size:2rem; font-weight:900; letter-spacing:-0.04em; color:var(--text-main); line-height:1.1; margin-bottom:0.3rem;">{{ $colocation->name }}</h1>
            <p style="font-size:0.82rem; color:var(--text-dim); font-weight:600;">{{ $members->count() }} members · {{ $colocation->expenses->count() }} expenses</p>
        </div>
        <div style="display:flex; gap:0.75rem; align-items:center;">
            <button onclick="ui.openModal('inviteModal')" class="btn-ghost" style="padding:0.65rem 1.25rem; font-size:0.8rem;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Invite Member
            </button>
            <button onclick="ui.openModal('addExpenseModal')" class="btn-premium" style="font-size:0.85rem;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                Add Expense
            </button>
        </div>
    </div>
</div>

{{-- ── KPI Strip ── --}}
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:2rem;">
    <div class="stat-box">
        <div class="stat-value">{{ number_format($total, 0) }}</div>
        <div class="stat-label">Total (DH)</div>
    </div>
    <div class="stat-box" style="border-color:rgba(204,174,164,0.2);">
        <div class="stat-value" style="color:var(--secondary);">{{ number_format($share, 0) }}</div>
        <div class="stat-label">Fair Share / Member (DH)</div>
    </div>
    <div class="stat-box">
        <div class="stat-value" style="color:var(--accent);">{{ $members->count() }}</div>
        <div class="stat-label">Members</div>
    </div>
</div>

{{-- ── Main Grid ── --}}
<div style="display:grid; grid-template-columns:340px 1fr; gap:1.25rem; align-items:start;">

    {{-- ── LEFT: Member Balances ── --}}
    <div>
        <div class="glass-card" style="padding:1.75rem;">
            <h3 style="font-size:1rem; font-weight:800; color:var(--text-main); margin-bottom:1.25rem; letter-spacing:-0.02em;">Member Balances</h3>

            <div style="display:flex; flex-direction:column; gap:0.6rem;">
                @foreach($members as $member)
                    @php $isMe = $member->id === auth()->id(); $positive = $member->balance >= 0; @endphp
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:0.9rem 1rem; border-radius:var(--radius-sm); background:rgba(0,0,0,0.15); border:1px solid var(--border-card); transition:border-color 0.2s;"
                         onmouseover="this.style.borderColor='var(--border)'" onmouseout="this.style.borderColor='var(--border-card)'">
                        <div style="display:flex; align-items:center; gap:0.75rem;">
                            <div style="width:36px; height:36px; border-radius:10px; background:var(--bg-elevated); display:flex; align-items:center; justify-content:center; font-size:0.85rem; font-weight:900; color:{{ $isMe ? 'var(--primary)' : 'var(--text-muted)' }}; border:1px solid var(--border);">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size:0.85rem; font-weight:800; color:var(--text-main);">
                                    {{ $member->name }}
                                    @if($isMe)<span style="font-size:0.6rem; color:var(--primary); margin-left:6px; font-weight:800; text-transform:uppercase; letter-spacing:0.1em;">(you)</span>@endif
                                </div>
                                <div style="font-size:0.65rem; color:var(--text-dim); font-weight:600; margin-top:2px;">Paid: {{ number_format($member->paid, 0) }} DH</div>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:1rem; font-weight:900; letter-spacing:-0.03em; color:{{ $positive ? 'var(--success)' : 'var(--danger)' }};">
                                {{ $positive ? '+' : '-' }}{{ number_format(abs($member->balance), 0) }}
                            </div>
                            <div style="font-size:0.6rem; color:var(--text-dim); font-weight:700; text-transform:uppercase; letter-spacing:0.08em; margin-top:2px;">
                                {{ $positive ? 'owed to them' : 'owes' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Settle button for negative balance --}}
            @php $personalMember = $members->where('id', auth()->id())->first(); @endphp
            @if($personalMember && $personalMember->balance < 0)
                <button onclick="ui.openModal('settleModal')" class="btn-danger" style="width:100%; margin-top:1.25rem; justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    Settle My Balance
                </button>
            @endif
        </div>
    </div>

    {{-- ── RIGHT: Expense Log ── --}}
    <div class="glass-card" style="padding:0; overflow:hidden;">
        <div style="display:flex; align-items:center; justify-content:space-between; padding:1.5rem 2rem; border-bottom:1px solid var(--border-card);">
            <h3 style="font-size:1rem; font-weight:800; color:var(--text-main); letter-spacing:-0.02em;">Expense History</h3>
            <span style="font-size:0.65rem; color:var(--text-dim); font-weight:700; text-transform:uppercase; letter-spacing:0.1em;">Last 10 entries</span>
        </div>

        <div>
            @forelse($colocation->expenses->sortByDesc('expense_date')->take(10) as $expense)
                <div style="display:flex; align-items:center; justify-content:space-between; padding:1.1rem 2rem; border-bottom:1px solid var(--border-card); transition:background 0.2s;"
                     onmouseover="this.style.background='rgba(255,174,157,0.04)'" onmouseout="this.style.background='transparent'">
                    <div style="display:flex; align-items:center; gap:1rem;">
                        {{-- Date chip --}}
                        <div style="width:44px; text-align:center; flex-shrink:0;">
                            <div style="font-size:0.55rem; font-weight:800; text-transform:uppercase; color:var(--text-dim); letter-spacing:0.12em;">
                                {{ \Carbon\Carbon::parse($expense->expense_date)->format('M') }}
                            </div>
                            <div style="font-size:1.3rem; font-weight:900; letter-spacing:-0.04em; color:var(--text-main); line-height:1;">
                                {{ \Carbon\Carbon::parse($expense->expense_date)->format('d') }}
                            </div>
                        </div>
                        {{-- Divider --}}
                        <div style="width:1px; height:32px; background:var(--border); flex-shrink:0;"></div>
                        {{-- Info --}}
                        <div>
                            <div style="font-size:0.9rem; font-weight:800; color:var(--text-main); margin-bottom:4px;">{{ $expense->title }}</div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span class="badge badge-warm">{{ $expense->category->name ?? 'General' }}</span>
                                <span style="font-size:0.68rem; color:var(--text-dim); font-weight:600;">by {{ $expense->payer->name }}</span>
                                @if($expense->payer_id === auth()->id())
                                    <span class="badge badge-peach">You</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div style="font-size:1.1rem; font-weight:900; letter-spacing:-0.03em; color:var(--text-main); white-space:nowrap;">
                        {{ number_format($expense->amount, 2) }}
                        <span style="font-size:0.7rem; color:var(--primary); font-weight:700; font-style:italic;">DH</span>
                    </div>
                </div>
            @empty
                <div style="padding:4rem 2rem; text-align:center; color:var(--text-dim);">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:40px;height:40px;margin:0 auto 1rem;opacity:0.3;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p style="font-size:0.85rem; font-weight:700;">No expenses recorded yet.</p>
                    <p style="font-size:0.75rem; margin-top:0.25rem; opacity:0.6;">Add the first expense to get started.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

{{-- ═══ MODALS ═══ --}}

{{-- Add Expense --}}
<div id="addExpenseModal" class="modal-overlay-v3">
    <div class="modal-content-v3">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem;">
            <div>
                <div class="page-eyebrow" style="margin-bottom:0.4rem;">Log Entry</div>
                <h2 class="modal-title">Add Expense</h2>
            </div>
            <button onclick="ui.closeModal('addExpenseModal')" class="modal-close">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('expenses.store') }}" method="POST">
            @csrf
            <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">
            <div style="display:flex; flex-direction:column; gap:1.1rem; margin-bottom:2rem;">
                <div>
                    <label class="field-label">Description</label>
                    <input type="text" name="title" class="modern-input" placeholder="e.g. Monthly Rent" required>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div>
                        <label class="field-label">Amount (DH)</label>
                        <input type="number" step="0.01" min="0" name="amount" class="modern-input" placeholder="0.00" required>
                    </div>
                    <div>
                        <label class="field-label">Date</label>
                        <input type="date" name="expense_date" class="modern-input" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div>
                        <label class="field-label">Category</label>
                        <select name="category_id" class="modern-input" required>
                            <option value="">— Select —</option>
                            @foreach($colocation->categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="field-label">Paid By</label>
                        <select name="payer_id" class="modern-input" required>
                            @foreach($colocation->users as $u)
                                <option value="{{ $u->id }}" @selected($u->id === auth()->id())>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div style="display:flex; gap:0.75rem;">
                <button type="submit" class="btn-premium" style="flex:1;">Save Expense</button>
                <button type="button" onclick="ui.closeModal('addExpenseModal')" class="btn-ghost">Cancel</button>
            </div>
        </form>
    </div>
</div>

{{-- Invite Member --}}
<div id="inviteModal" class="modal-overlay-v3">
    <div class="modal-content-v3">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem;">
            <div>
                <div class="page-eyebrow" style="margin-bottom:0.4rem;">Collaboration</div>
                <h2 class="modal-title">Invite a Member</h2>
            </div>
            <button onclick="ui.closeModal('inviteModal')" class="modal-close">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('invitations.invite') }}" method="POST">
            @csrf
            <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">
            <div style="margin-bottom:2rem;">
                <label class="field-label">Email Address</label>
                <input type="email" name="email" class="modern-input" placeholder="colleague@example.com" required>
                <p style="font-size:0.72rem; color:var(--text-dim); margin-top:0.5rem;">They'll receive an invitation to join <strong style="color:var(--text-muted);">{{ $colocation->name }}</strong>.</p>
            </div>
            <div style="display:flex; gap:0.75rem;">
                <button type="submit" class="btn-premium" style="flex:1;">Send Invitation</button>
                <button type="button" onclick="ui.closeModal('inviteModal')" class="btn-ghost">Cancel</button>
            </div>
        </form>
    </div>
</div>

{{-- Settle Balance --}}
<div id="settleModal" class="modal-overlay-v3">
    <div class="modal-content-v3">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem;">
            <div>
                <div class="page-eyebrow" style="margin-bottom:0.4rem;">Settlement</div>
                <h2 class="modal-title">Settle Balance</h2>
            </div>
            <button onclick="ui.closeModal('settleModal')" class="modal-close">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">
            <div style="display:flex; flex-direction:column; gap:1.1rem; margin-bottom:2rem;">
                <div>
                    <label class="field-label">Pay to</label>
                    <select name="to_user_id" class="modern-input" required>
                        <option value="">— Select member —</option>
                        @foreach($members as $m)
                            @if($m->id !== auth()->id())
                                <option value="{{ $m->id }}">{{ $m->name }}{{ $m->balance > 0 ? ' (owed ' . number_format($m->balance, 0) . ' DH)' : '' }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="field-label">Amount (DH)</label>
                    <input type="number" step="0.01" min="0.01" name="amount" class="modern-input" placeholder="0.00"
                           value="{{ $personalMember && $personalMember->balance < 0 ? number_format(abs($personalMember->balance), 2, '.', '') : '' }}" required>
                </div>
            </div>
            <div style="display:flex; gap:0.75rem;">
                <button type="submit" class="btn-premium" style="flex:1;">Confirm Payment</button>
                <button type="button" onclick="ui.closeModal('settleModal')" class="btn-ghost">Cancel</button>
            </div>
        </form>
    </div>
</div>

</x-app-layout>
