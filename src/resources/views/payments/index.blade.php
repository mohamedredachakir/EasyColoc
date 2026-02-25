<x-app-layout>

<div style="margin-bottom:2.5rem;" class="animate-smooth">
    <div class="page-eyebrow">Settlements</div>
    <h1 class="page-title">Payment History</h1>
    <p class="page-subtitle">All balance settlements recorded across your spaces.</p>
</div>

<div class="glass-card" style="padding:0; overflow:hidden;">
    <table class="vtable">
        <thead>
            <tr>
                <th style="text-align:left;">From</th>
                <th style="text-align:left;">To</th>
                <th style="text-align:left;">Space</th>
                <th style="text-align:left;">Date</th>
                <th style="text-align:right;">Amount (DH)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:32px; height:32px; border-radius:9px; background:rgba(221,128,128,0.1); border:1px solid rgba(221,128,128,0.2); display:flex; align-items:center; justify-content:center; font-size:0.7rem; font-weight:900; color:var(--danger);">
                                {{ strtoupper(substr($payment->fromUser->name, 0, 1)) }}
                            </div>
                            <span style="font-size:0.85rem; font-weight:700; color:var(--text-main);">{{ $payment->fromUser->name }}</span>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:32px; height:32px; border-radius:9px; background:rgba(168,197,160,0.1); border:1px solid rgba(168,197,160,0.2); display:flex; align-items:center; justify-content:center; font-size:0.7rem; font-weight:900; color:var(--success);">
                                {{ strtoupper(substr($payment->toUser->name, 0, 1)) }}
                            </div>
                            <span style="font-size:0.85rem; font-weight:700; color:var(--text-main);">{{ $payment->toUser->name }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-warm">{{ $payment->colocation->name }}</span>
                    </td>
                    <td>
                        <span style="font-size:0.78rem; font-weight:700; color:var(--text-dim);">{{ $payment->paid_at->format('d M Y') }}</span>
                    </td>
                    <td style="text-align:right;">
                        <span style="font-size:1.1rem; font-weight:900; letter-spacing:-0.03em; color:var(--text-main);">{{ number_format($payment->amount, 2) }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:4rem; color:var(--text-dim);">
                        <p style="font-size:0.85rem; font-weight:700;">No payments recorded yet.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</x-app-layout>
