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
        $colocations = $user->colocations()->with('users', 'expenses', 'categories')->get();
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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $colocation = Colocation::create([
            'name' => $request->name,
            'owner_id' => auth()->id(),
            'status' => ColocationStatus::ACTIVE,
        ]);

        if (!$colocation) {
            return redirect()->back()->with('error', 'Colocation not created.');
        }

        // Add the creator as a member too
        $colocation->users()->attach(auth()->id(), ['joined_at' => now()]);

        return redirect()->route('colocations.index')->with('success', 'Colocation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation)
    {
        // Security: Ensure user belongs to this colocation
        if (!$colocation->users->contains(auth()->id())) {
            abort(403, 'Unauthorized access to this colocation.');
        }

        $colocation->load('users', 'expenses.payer', 'categories', 'invitations.receiver');

        $total = $colocation->expenses->sum('amount');
        $membersCount = $colocation->users->count();
        $share = $membersCount > 0 ? $total / $membersCount : 0;

        $members = $colocation->users->map(function ($user) use ($colocation, $share) {
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
        if ($colocation->owner_id !== auth()->id()) {
            abort(403, 'Only the owner can edit colocation settings.');
        }
        return view('colocations.edit', compact('colocation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colocation $colocation)
    {
        if ($colocation->owner_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $colocation->update([
            'name' => $request->name,
        ]);

        return redirect()->route('colocations.index')->with('success', 'Colocation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation)
    {
        if ($colocation->owner_id !== auth()->id()) {
            abort(403);
        }

        $colocation->delete();
        return redirect()->route('colocations.index')->with('success', 'Colocation deleted successfully.');
    }
}
