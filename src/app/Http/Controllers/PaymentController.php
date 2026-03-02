<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\ColocationUser;
use App\Models\User;
use App\Models\Colocation;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::all();
        return view('payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colocations = \App\Models\Colocation::whereHas('users', fn($q) => $q->where('user_id', auth()->id()))->get();
        return view('payment.create', compact('colocations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            
        ]);
        Payment::create([
            'name' => $request->name,
            'colocation_id' => $request->colocation_id,
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'payment_date' => now(),
        ]);

        ColocationUser::where('user_id', auth()->user()->id)
            ->where('colocation_id', $request->colocation_id)
            ->increment('amount', $request->amount);
        return redirect()->route('payment.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::findOrFail($id);
        return view('payment.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::findOrFail($id);
        if($payment->user_id != auth()->user()->id){
            return back()->with('error', 'You are not authorized to edit this payment.');
        }
        return view('payment.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            
        ]);
        $payment = Payment::findOrFail($id);
        $payment->update([
            'name' => $request->name,
            'colocation_id' => $request->colocation_id,
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'payment_date' => now(),
        ]);

        ColocationUser::where('user_id', auth()->user()->id)
            ->where('colocation_id', $request->colocation_id)
            ->increment('amount', $request->amount);
        return redirect()->route('payment.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        if($payment->user_id != auth()->user()->id){
            return back()->with('error', 'You are not authorized to delete this payment.');
        }
        $payment->delete();
        return redirect()->route('payment.index');
    }
}
