<x-app-layout>
    <div class="max-w-xl mx-auto py-12">
        <div class="mb-8">
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Update Expense</h2>
            <p class="text-gray-500">Modify details for <span class="text-blue-600 font-bold">{{ $expense->title }}</span>.</p>
        </div>

        <div class="premium-card">
            <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Description</label>
                        <input type="text" name="title" class="modern-input" value="{{ old('title', $expense->title) }}" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Amount (DH)</label>
                            <input type="number" step="0.01" name="amount" class="modern-input" value="{{ old('amount', $expense->amount) }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Date</label>
                            <input type="date" name="expense_date" class="modern-input" value="{{ old('expense_date', $expense->expense_date) }}" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Category</label>
                            <select name="category_id" class="modern-input" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected($category->id == $expense->category_id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Paid By</label>
                            <select name="payer_id" class="modern-input" required>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" @selected($member->id == $expense->payer_id)>{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex gap-4">
                        <button type="submit" class="btn-premium flex-1 justify-center">Update Record</button>
                        <a href="{{ route('expenses.index') }}" class="px-6 py-3 font-bold text-gray-500 hover:text-gray-800 transition-colors">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
