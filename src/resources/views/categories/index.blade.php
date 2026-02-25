<x-app-layout>

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2.5rem;" class="animate-smooth">
    <div>
        <div class="page-eyebrow">Organisation</div>
        <h1 class="page-title">Categories</h1>
        <p class="page-subtitle">Organise expenses by type across your spaces.</p>
    </div>
    <button onclick="ui.openModal('addCategoryModal')" class="btn-premium">
        <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
        </svg>
        Add Category
    </button>
</div>

@if($categories->isEmpty())
    <div style="padding:5rem 2rem; text-align:center; border:1px dashed var(--border); border-radius:var(--radius-lg);">
        <p style="font-size:0.9rem; color:var(--text-dim); margin-bottom:1.5rem;">No categories defined yet.</p>
        <button onclick="ui.openModal('addCategoryModal')" class="btn-premium">Create First Category</button>
    </div>
@else
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(230px, 1fr)); gap:1rem;">
        @foreach($categories as $category)
            <div class="glass-card" style="padding:1.5rem; position:relative; overflow:hidden;">
                <div style="position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg, var(--primary), var(--accent)); border-radius:var(--radius-lg) var(--radius-lg) 0 0; opacity:0.6;"></div>

                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1rem;">
                    <div style="width:40px; height:40px; border-radius:12px; background:var(--primary-dim); border:1px solid var(--border-bright); display:flex; align-items:center; justify-content:center; font-size:1rem; font-weight:900; color:var(--primary);">
                        {{ strtoupper(substr($category->name, 0, 1)) }}
                    </div>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                        @csrf @method('DELETE')
                        <button style="width:30px; height:30px; border-radius:8px; border:1px solid transparent; background:transparent; display:flex; align-items:center; justify-content:center; color:var(--text-dim); cursor:pointer; transition:all 0.2s;"
                                onmouseover="this.style.background='rgba(221,128,128,0.1)'; this.style.color='var(--danger)'; this.style.borderColor='rgba(221,128,128,0.25)'"
                                onmouseout="this.style.background='transparent'; this.style.color='var(--text-dim)'; this.style.borderColor='transparent'">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <div style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.14em; color:var(--primary); margin-bottom:0.3rem; opacity:0.8;">{{ $category->colocation->name }}</div>
                <h3 style="font-size:1rem; font-weight:800; color:var(--text-main); letter-spacing:-0.02em; margin-bottom:0.75rem;">{{ $category->name }}</h3>

                <div style="padding-top:0.75rem; border-top:1px solid var(--border-card);">
                    <span style="font-size:0.68rem; font-weight:700; color:var(--text-dim);">{{ $category->expenses->count() }} {{ Str::plural('expense', $category->expenses->count()) }}</span>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Add Category Modal --}}
<div id="addCategoryModal" class="modal-overlay-v3">
    <div class="modal-content-v3">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem;">
            <div>
                <div class="page-eyebrow" style="margin-bottom:0.4rem;">Organisation</div>
                <h2 class="modal-title">New Category</h2>
            </div>
            <button onclick="ui.closeModal('addCategoryModal')" class="modal-close">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div style="display:flex; flex-direction:column; gap:1.1rem; margin-bottom:2rem;">
                <div>
                    <label class="field-label">Category Name</label>
                    <input type="text" name="name" class="modern-input" placeholder="e.g. Rent, Groceries, Internet..." required autofocus>
                </div>
                <div>
                    <label class="field-label">Space</label>
                    <select name="colocation_id" class="modern-input" required>
                        <option value="">— Select a space —</option>
                        @foreach(auth()->user()->colocations as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="display:flex; gap:0.75rem;">
                <button type="submit" class="btn-premium" style="flex:1;">Create Category</button>
                <button type="button" onclick="ui.closeModal('addCategoryModal')" class="btn-ghost">Cancel</button>
            </div>
        </form>
    </div>
</div>

</x-app-layout>
