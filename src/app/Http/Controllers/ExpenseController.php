<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\Colocation;
use App\Models\User;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Only expenses from colocations the user belongs to
        $expenses = Expense::whereIn('colocation_id', auth()->user()->colocations->pluck('id'))
            ->with(['colocation', 'category', 'payer'])
            ->latest('expense_date')
            ->get();
            
        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        $colocations = $user->colocations;
        
        $selected_colocation_id = $request->query('colocation_id');
        $categories = collect();
        $members = collect();

        if ($selected_colocation_id) {
            $colocation = $colocations->find($selected_colocation_id);
            if ($colocation) {
                $categories = $colocation->categories;
                $members = $colocation->users;
            }
        }

        return view('expenses.create', compact('colocations', 'categories', 'members', 'selected_colocation_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'colocation_id' => 'required|exists:colocations,id',
            'category_id' => 'required|exists:categories,id',
            'payer_id' => 'required|exists:users,id',
        ]);

        // user belongs to this colocation
        $colocation = auth()->user()->colocations()->find($request->colocation_id);
        if (!$colocation) {
            return redirect()->back()->with('error', 'Unauthorized colocation.');
        }

        $expense = Expense::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'colocation_id' => $request->colocation_id,
            'category_id' => $request->category_id,
            'payer_id' => $request->payer_id,
        ]);

        if(!$expense){return redirect()->back()->with('error', 'Expense not created.');}

        return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        // Check if user belongs to the colocation of the expense
        if (!auth()->user()->colocations->contains($expense->colocation_id)) {
            abort(403);
        }

        $expense->load(['colocation', 'category', 'payer']);
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        if (!auth()->user()->colocations->contains($expense->colocation_id)) {
            abort(403);
        }

        $colocations = auth()->user()->colocations;
        $categories = $expense->colocation->categories;
        $members = $expense->colocation->users;

        return view('expenses.edit', compact('expense', 'colocations', 'categories', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        if (!auth()->user()->colocations->contains($expense->colocation_id)) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'payer_id' => 'required|exists:users,id',
        ]);

        $check = $expense->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'category_id' => $request->category_id,
            'payer_id' => $request->payer_id,
        ]);

        if(!$check){return redirect()->back()->with('error', 'Expense not updated.');}

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        if (!auth()->user()->colocations->contains($expense->colocation_id)) {
            abort(403);
        }

        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
