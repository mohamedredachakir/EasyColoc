<x-app-layout>

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2.5rem;" class="animate-smooth">
    <div>
        <div class="page-eyebrow">Finance</div>
        <h1 class="page-title">All Expenses</h1>
        <p class="page-subtitle">Complete transaction history across all your spaces.</p>
    </div>
</div>

<div class="glass-card" style="padding:0; overflow:hidden;">
    <table class="vtable">
        <thead>
            <tr>
                <th style="text-align:left;">Description</th>
                <th style="text-align:left;">Space</th>
                <th style="text-align:left;">Paid By</th>
                <th style="text-align:left;">Date</th>
                <th style="text-align:right;">Amount (DH)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:36px; height:36px; border-radius:10px; background:var(--bg-elevated); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:900; color:var(--accent); flex-shrink:0;">
                                {{ strtoupper(substr($expense->category->name ?? 'G', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:800; color:var(--text-main); font-size:0.9rem;">{{ $expense->title }}</div>
                                <span class="badge badge-warm" style="margin-top:4px;">{{ $expense->category->name ?? 'General' }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('colocations.show', $expense->colocation->id) }}" style="color:var(--primary); font-weight:700; font-size:0.82rem; text-decoration:none;"
                           onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                            {{ $expense->colocation->name }}
                        </a>
                    </td>
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:28px; height:28px; border-radius:8px; background:var(--bg-elevated); display:flex; align-items:center; justify-content:center; font-size:0.65rem; font-weight:900; color:var(--text-muted); border:1px solid var(--border);">
                                {{ strtoupper(substr($expense->payer->name, 0, 1)) }}
                            </div>
                            <span style="font-size:0.82rem; font-weight:700; color:var(--text-muted);">{{ $expense->payer->name }}</span>
                        </div>
                    </td>
                    <td>
                        <span style="font-size:0.78rem; font-weight:700; color:var(--text-dim);">
                            {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <span style="font-size:1.1rem; font-weight:900; letter-spacing:-0.03em; color:var(--text-main);">
                            {{ number_format($expense->amount, 2) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:4rem; color:var(--text-dim);">
                        <p style="font-size:0.85rem; font-weight:700;">No expenses found.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</x-app-layout>
