<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Category;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Enums\ColocationStatus;
class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $colocations = $user->colocations()->with('users','expenses','categories')->get();
        return view('colocations.index', compact('colocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('colocations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validateWithBag('colocation', [
            'name' => ['required|string|max:255'],
        ]);

        $colocation = Colocation::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
            'status' =>  ColocationStatus::ACTIVE,
        ]);

        if(!$colocation){return redirect()->back()->with('error', 'Colocation not created.');}

        return redirect()->route('colocations.index')->with('success', 'Colocation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation)
    {
        $colocation->load('users','expenses.payer','categories','invitations.receiver');

        $total = $colocation->expenses->sum('amount');
        $membersCount = $colocation->users->count();
        $share = $membersCount > 0 ? $total / $membersCount : 0;

        $members = $colocation->users->map(function($user) use ($colocation, $share) {
            $totalPaid = $colocation->expenses
                            ->where('payer_id', $user->id)
                            ->sum('amount');

            $user->paid = $totalPaid;
            $user->balance = $totalPaid - $share;

            return $user;
        });

        return view('colocations.show', compact('colocation', 'members', 'total', 'share'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation)
    {
        $this->authorize('update', $colocation);
        return view('colocations.edit', compact('colocation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colocation $colocation)
    {
        $this->authorize('update', $colocation);
        $request->validate([
        'name' => 'required|string|max:255',
        ]);

        $colocation->update([
            'name' => $request->name,
        ]);

        if(!$colocation){return redirect()->back()->with('error', 'Colocation not updated.');}

        return redirect()->route('colocations.index')->with('success', 'Colocation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation)
    {
        $this->authorize('delete', $colocation);
        $colocation->delete();
        return redirect()->route('colocations.index')->with('success', 'Colocation deleted successfully.');
    }
}
