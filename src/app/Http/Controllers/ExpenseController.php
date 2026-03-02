<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Category;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::all();
        return view('expense.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $colocations = \App\Models\Colocation::whereHas('users', fn($q) => $q->where('user_id', auth()->id()))->get();
        return view('expense.create', compact('categories', 'colocations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'colocation_id' => 'required',
            'category_id' => 'required',
            'user_id' => 'required',
            'amount' => 'required',
            
        ]);
        Expense::create([
            'name' => $request->name,
            'colocation_id' => $request->colocation_id,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'expense_date' => now(),
        ]);

        $rowMembers = \App\Models\ColocationUser::where('colocation_id', $request->colocation_id)->count();
        $amountPerMember = $request->amount / max($rowMembers, 1);
        \App\Models\ColocationUser::where('colocation_id', $request->colocation_id)->update([
            'amount' => \DB::raw("amount - $amountPerMember"),
        ]);
        
        // Crediting the person who paid the full amount
        \App\Models\ColocationUser::where('colocation_id', $request->colocation_id)
            ->where('user_id', $request->user_id)
            ->update([
                'amount' => \DB::raw("amount + $request->amount"),
            ]);

        return redirect()->route('expense.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense = Expense::findOrFail($id);
        return view('expense.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expense = Expense::findOrFail($id);
        if($expense->user_id != auth()->user()->id){
            return back()->with('error', 'You are not authorized to edit this expense.');
        }
        $categories = Category::all();

        return view('expense.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'colocation_id' => 'required',
            'category_id' => 'required',
            'user_id' => 'required',
            'amount' => 'required',
        ]);
        $expense = Expense::findOrFail($id);
        $expense->update([
            'name' => $request->name,
            'colocation_id' => $request->colocation_id,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'expense_date' => now(),
        ]);
        return redirect()->route('expense.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::findOrFail($id);
        if($expense->user_id != auth()->user()->id){
            return back()->with('error', 'You are not authorized to delete this expense.');
        }
        $expense->delete();
        return redirect()->route('expense.index');
    }
}
