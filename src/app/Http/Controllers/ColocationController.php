<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\ColocationUser;
use App\enum\ColocationStatus;


class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $colocations = ColocationUser::where('user_id', $user->id)->get();
        return view('colocation.index', compact('colocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        $checkuser = ColocationUser::where('user_id', $user->id)->exists();
        if($checkuser){
            return back()->with('error', 'You are already a member of a colocation.');
        }
        $colocations = ColocationUser::where('user_id', $user->id)->get();
        return view('colocation.create', compact('colocations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        Colocation::create([
            'name' => $request->name,
            'owner_id' => auth()->user()->id,
            'status' => ColocationStatus::ACTIVE,
        ]);

        ColocationUser::create([
            'colocation_id' => Colocation::latest()->first()->id,
            'user_id' => auth()->user()->id,
            'amount' => 0,
            'entry_date' => now(),
            'exit_date' => null,
        ]);

        User::where('id', auth()->user()->id)->update([
            'role' => 'owner',
        ]);
        return redirect()->route('colocation.index')->with('success', 'Colocation created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $colocation = Colocation::findOrFail($id);
        return view('colocation.show', compact('colocation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $colocation = Colocation::findOrFail($id);
        return view('colocation.edit', compact('colocation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $colocation = Colocation::findOrFail($id);
        $colocation->update([
            'name' => $request->name,
        ]);
        return redirect()->route('colocation.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $colocation = Colocation::findOrFail($id);
        $colocation->delete();
        User::where('id', auth()->user()->id)->update([
            'role' => 'user',
        ]);
        return redirect()->route('colocation.index');
    }

    public function leave(string $id)
    {
        $colocation = Colocation::findOrFail($id);
        $amount = ColocationUser::where('user_id', auth()->user()->id)->where('colocation_id', $colocation->id)->value('amount');

        if($amount < 0){
            User::where('id', auth()->user()->id)->update([
                'reputation' => auth()->user()->reputation - 1,
            ]);
            User::where('id', auth()->user()->id)->update([
                'role' => 'user',
            ]);
            ColocationUser::where('user_id', auth()->user()->id)->where('colocation_id', $colocation->id)->delete();
        }

        else if($amount > 0){
            User::where('id', auth()->user()->id)->update([
                'reputation' => auth()->user()->reputation + 1,
            ]);
            User::where('id', auth()->user()->id)->update([
                'role' => 'user',
            ]);
            ColocationUser::where('user_id', auth()->user()->id)->where('colocation_id', $colocation->id)->delete();
        }

          
        return redirect()->route('colocation.index');
    }
}
