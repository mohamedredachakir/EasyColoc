<x-app-layout>

<div style="margin-bottom:2.5rem;" class="animate-smooth">
    <div class="page-eyebrow">Administration</div>
    <h1 class="page-title">Admin Panel</h1>
    <p class="page-subtitle">Manage users, monitor the platform, and maintain system health.</p>
</div>

{{-- Stats --}}
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:2.5rem;">
    <div class="stat-box">
        <div class="stat-value">{{ $stats['total_users'] }}</div>
        <div class="stat-label">Total Users</div>
    </div>
    <div class="stat-box" style="border-color:var(--border-bright);">
        <div class="stat-value" style="color:var(--secondary);">{{ $stats['total_colocations'] }}</div>
        <div class="stat-label">Active Spaces</div>
    </div>
    <div class="stat-box">
        <div class="stat-value" style="color:var(--accent); font-size:2rem;">{{ number_format($stats['total_expenses'], 0) }}</div>
        <div class="stat-label">Platform Volume (DH)</div>
    </div>
</div>

{{-- User Table --}}
<div class="glass-card" style="padding:0; overflow:hidden;">
    <div style="display:flex; align-items:center; justify-content:space-between; padding:1.25rem 2rem; border-bottom:1px solid var(--border-card);">
        <h3 style="font-size:1rem; font-weight:800; color:var(--text-main);">Users</h3>
        <input type="text" class="modern-input" style="width:220px; padding:0.55rem 1rem; font-size:0.82rem;"
               placeholder="Search users…" oninput="filterUsers(this.value)">
    </div>

    <table class="vtable" id="users-table">
        <thead>
            <tr>
                <th style="text-align:left;">User</th>
                <th style="text-align:left;">Role</th>
                <th style="text-align:left;">Status</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                    <td>
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:38px; height:38px; border-radius:11px; background:var(--primary-dim); border:1px solid var(--border-bright); display:flex; align-items:center; justify-content:center; font-size:0.9rem; font-weight:900; color:var(--primary); flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:800; color:var(--text-main); font-size:0.9rem;">{{ $user->name }}</div>
                                <div style="font-size:0.68rem; color:var(--text-dim); font-weight:600;">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-warm">{{ $user->role }}</span>
                    </td>
                    <td>
                        @if($user->is_banned)
                            <span class="badge badge-danger">
                                <span class="badge-dot" style="background:var(--danger);"></span>
                                Suspended
                            </span>
                        @else
                            <span class="badge badge-warm">
                                <span class="badge-dot" style="background:var(--success);"></span>
                                Active
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:0.5rem;">
                            @if($user->is_banned)
                                <form action="{{ route('admin.unban', $user->id) }}" method="POST">
                                    @csrf
                                    <button class="btn-ghost" style="padding:0.45rem 0.9rem; font-size:0.75rem; font-weight:800;">Restore</button>
                                </form>
                            @else
                                <form action="{{ route('admin.ban', $user->id) }}" method="POST">
                                    @csrf
                                    <button class="btn-danger" style="padding:0.45rem 0.9rem; font-size:0.75rem;">Suspend</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete user {{ $user->name }}?');">
                                @csrf @method('DELETE')
                                <button style="width:34px; height:34px; border-radius:9px; border:1px solid transparent; background:transparent; display:flex; align-items:center; justify-content:center; color:var(--text-dim); cursor:pointer; transition:all 0.2s;"
                                        onmouseover="this.style.background='rgba(221,128,128,0.1)'; this.style.color='var(--danger)'; this.style.borderColor='rgba(221,128,128,0.2)'"
                                        onmouseout="this.style.background='transparent'; this.style.color='var(--text-dim)'; this.style.borderColor='transparent'">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width:15px;height:15px;" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
function filterUsers(query) {
    const q = query.toLowerCase();
    document.querySelectorAll('#users-table tbody tr').forEach(row => {
        row.style.display = row.dataset.search.includes(q) ? '' : 'none';
    });
}
</script>

</x-app-layout>
