@extends('admin.layout')
@section('title', 'Users — Admin')
@section('page-title', 'Users')
@section('page-subtitle', 'Manage all registered users')

@section('head')
<style>
    .users-card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .users-header { padding: 16px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .users-header h2 { font-size: 14px; font-weight: 600; }
    .search-input { background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 7px 12px; color: var(--text); font-size: 13px; font-family: var(--font); width: 220px; }
    .search-input:focus { outline: none; border-color: var(--accent); }
    .search-input::placeholder { color: var(--text-3); }

    .table-head { display: grid; grid-template-columns: 2fr 2fr 1fr 1fr 1fr; gap: 12px; padding: 10px 22px; border-bottom: 1px solid var(--border); }
    .table-head span { font-size: 11px; font-weight: 600; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.06em; }

    .user-row { display: grid; grid-template-columns: 2fr 2fr 1fr 1fr 1fr; gap: 12px; padding: 13px 22px; border-bottom: 1px solid var(--border); align-items: center; transition: background 0.15s; }
    .user-row:last-child { border-bottom: none; }
    .user-row:hover { background: rgba(255,255,255,0.02); }

    .user-cell { display: flex; align-items: center; gap: 10px; min-width: 0; }
    .user-avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), var(--accent-2)); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; flex-shrink: 0; }
    .user-name { font-size: 13.5px; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .user-email { font-size: 12.5px; color: var(--text-2); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .user-date { font-size: 12px; color: var(--text-3); }
    .user-tunnels { font-size: 13px; font-weight: 500; }

    .plan-select { background: var(--bg-3); border: 1px solid var(--border); border-radius: 6px; padding: 4px 8px; color: var(--text); font-size: 12px; font-family: var(--font); cursor: pointer; transition: all 0.15s; }
    .plan-select:focus { outline: none; border-color: var(--accent); }

    .action-btns { display: flex; align-items: center; gap: 6px; }
    .icon-btn { color: var(--text-3); transition: color 0.15s; padding: 4px; background: none; border: none; cursor: pointer; border-radius: 4px; }
    .icon-btn:hover { color: var(--red); background: rgba(255,95,126,0.08); }
    .icon-btn svg { width: 15px; height: 15px; display: block; }

    .empty-state { padding: 60px 20px; text-align: center; color: var(--text-3); font-size: 13px; }
</style>
@endsection

@section('content')

<div class="users-card">
    <div class="users-header">
        <h2>All Users <span style="color:var(--text-3);font-weight:400;font-size:13px;">({{ $users->count() }})</span></h2>
        <input class="search-input" type="text" id="search" placeholder="Search by name or email..." onkeyup="filterUsers()">
    </div>

    <div class="table-head">
        <span>Name</span>
        <span>Email</span>
        <span>Plan</span>
        <span>Joined</span>
        <span>Actions</span>
    </div>

    @if($users->isEmpty())
    <div class="empty-state">No users registered yet.</div>
    @else
    <div id="users-list">
        @foreach($users as $user)
        <div class="user-row" id="user-row-{{ $user->id }}" data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}">
            <div class="user-cell">
                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <span class="user-name">{{ $user->name }}</span>
            </div>
            <div class="user-email">{{ $user->email }}</div>
            <div>
                <select class="plan-select" onchange="updatePlan('{{ $user->id }}', this.value)">
                    <option value="free" {{ ($user->plan ?? 'free') === 'free' ? 'selected' : '' }}>Free</option>
                    <option value="pro" {{ ($user->plan ?? 'free') === 'pro' ? 'selected' : '' }}>Pro</option>
                </select>
            </div>
            <div class="user-date">{{ $user->created_at->format('M d, Y') }}</div>
            <div class="action-btns">
                <button class="icon-btn" onclick="deleteUser('{{ $user->id }}', '{{ $user->name }}')" title="Delete user">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="delete-modal">
    <div class="modal-box" style="max-width:380px;">
        <div class="modal-head">
            <h3>Delete User</h3>
            <button onclick="closeDeleteModal()"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="modal-body">
            <p style="font-size:14px;color:var(--text-2);line-height:1.6;">Are you sure you want to delete <strong id="delete-user-name" style="color:var(--text)"></strong>? This will also delete all their tunnels and tokens.</p>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger" id="delete-confirm-btn" onclick="confirmDelete()">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Delete User
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let pendingDeleteId = null;

    function filterUsers() {
        const q = document.getElementById('search').value.toLowerCase();
        document.querySelectorAll('#users-list .user-row').forEach(row => {
            const name = row.dataset.name || '';
            const email = row.dataset.email || '';
            row.style.display = (name.includes(q) || email.includes(q)) ? 'grid' : 'none';
        });
    }

    async function updatePlan(userId, plan) {
        try {
            const res = await fetch(`/admin/users/${userId}/plan`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ plan })
            });
            const data = await res.json();
            if (data.success) {
                showToast(`Plan updated to ${plan}!`);
            } else {
                showToast('Failed to update plan', 'error');
            }
        } catch(e) {
            showToast('Something went wrong', 'error');
        }
    }

    function deleteUser(userId, name) {
        pendingDeleteId = userId;
        document.getElementById('delete-user-name').textContent = name;
        document.getElementById('delete-modal').classList.add('open');
    }

    function closeDeleteModal() {
        pendingDeleteId = null;
        document.getElementById('delete-modal').classList.remove('open');
    }

    async function confirmDelete() {
        if (!pendingDeleteId) return;
        const btn = document.getElementById('delete-confirm-btn');
        btn.disabled = true;
        btn.textContent = 'Deleting...';

        try {
            const res = await fetch(`/admin/users/${pendingDeleteId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.success) {
                document.getElementById(`user-row-${pendingDeleteId}`)?.remove();
                closeDeleteModal();
                showToast('User deleted!');
            }
        } catch(e) {
            showToast('Failed to delete', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg> Delete User';
        }
    }
</script>
@endsection
