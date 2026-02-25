<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Colocation;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Only show payments from colocations the user belongs to
        $payments = Payment::whereIn('colocation_id', auth()->user()->colocations->pluck('id'))
            ->with(['fromUser', 'toUser', 'colocation'])
            ->latest('paid_at')
            ->get();
            
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        $colocations = $user->colocations;
        
        $selected_colocation_id = $request->query('colocation_id');
        $members = collect();

        if ($selected_colocation_id) {
            $colocation = $colocations->find($selected_colocation_id);
            if ($colocation) {
                // Potential recipients are other members of the colocation
                $members = $colocation->users->where('id', '!=', $user->id);
            }
        }

        return view('payments.create', compact('colocations', 'members', 'selected_colocation_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'colocation_id' => 'required|exists:colocations,id',
            'to_user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Security: Ensure user belongs to this colocation
        $colocation = auth()->user()->colocations()->find($request->colocation_id);
        if (!$colocation) {
            return redirect()->back()->with('error', 'Unauthorized colocation.');
        }

        // Security: Ensure recipient belongs to the same colocation
        if (!$colocation->users()->where('user_id', $request->to_user_id)->exists()) {
            return redirect()->back()->with('error', 'Recipient is not a member of this colocation.');
        }

        Payment::create([
            'colocation_id' => $request->colocation_id,
            'from_user_id' => auth()->id(),
            'to_user_id' => $request->to_user_id,
            'amount' => $request->amount,
            'paid_at' => now(),
        ]);

        return redirect()->route('colocations.show', $colocation->id)
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        if (!auth()->user()->colocations->contains($payment->colocation_id)) {
            abort(403);
        }

        $payment->load(['fromUser', 'toUser', 'colocation']);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        if (!auth()->user()->colocations->contains($payment->colocation_id)) {
            abort(403);
        }

        $colocations = auth()->user()->colocations;
        $members = $payment->colocation->users->where('id', '!=', auth()->id());

        return view('payments.edit', compact('payment', 'colocations', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        if (!auth()->user()->colocations->contains($payment->colocation_id)) {
            abort(403);
        }

        $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $payment->update([
            'to_user_id' => $request->to_user_id,
            'amount' => $request->amount,
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        if (!auth()->user()->colocations->contains($payment->colocation_id)) {
            abort(403);
        }

        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}
