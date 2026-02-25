<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Colocation;
use App\Models\User;
use App\Enums\InvitationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvitationController extends Controller
{
    public function index()
    {
        $invitations = Invitation::where('receiver_id', auth()->id())
            ->where('status', InvitationStatus::PENDING)
            ->with(['sender', 'colocation'])
            ->get();
            
        return view('invitations.index', compact('invitations'));
    }

    public function invite(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'colocation_id' => 'required|exists:colocations,id',
        ]);

        $receiver = User::where('email', $request->email)->first();
        
        // cnt invite yourself
        if ($receiver->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot invite yourself.');
        }

        // check if im allready in the colocation
        $colocation = Colocation::findOrFail($request->colocation_id);
        if ($colocation->users()->where('user_id', $receiver->id)->exists()) {
            return redirect()->back()->with('error', 'User is already a member of this colocation.');
        }

        // check if there is a pending invitation already
        $exists = Invitation::where('colocation_id', $request->colocation_id)
            ->where('receiver_id', $receiver->id)
            ->where('status', InvitationStatus::PENDING)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'An invitation is already pending for this user.');
        }

        $invite = Invitation::create([
            'colocation_id' => $request->colocation_id,
            'sender_id' => auth()->id(),
            'receiver_id' => $receiver->id,
            'status' => InvitationStatus::PENDING,
        ]);

        if (!$invite) {
            return redirect()->back()->with('error', 'Invitation not sent.');
        }
        return redirect()->back()->with('success', 'Invitation sent successfully.');
    }

    public function accept(Invitation $invitation)
    {
        if ($invitation->receiver_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($invitation->status !== InvitationStatus::PENDING) {
            return redirect()->route('invitations.index')->with('error', 'This invitation is no longer pending.');
        }

        DB::transaction(function() use ($invitation) {
            
            $invitation->update([
                'status' => InvitationStatus::ACCEPTED,
            ]);

            // Add user to the colocation members (pivot table colocation_users)
            $invitation->colocation->users()->attach($invitation->receiver_id, [
                'joined_at' => now()
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Invitation accepted! You are now a member of ' . $invitation->colocation->name);
    }

    public function refuse(Invitation $invitation)
    {
        
        if ($invitation->receiver_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($invitation->status !== InvitationStatus::PENDING) {
            return redirect()->route('invitations.index')->with('error', 'This invitation is no longer pending.');
        }

        $invitation->update([
            'status' => InvitationStatus::REJECTED,
        ]);

        return redirect()->route('invitations.index')->with('success', 'Invitation refused.');
    }
}
