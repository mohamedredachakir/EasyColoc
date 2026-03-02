<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\ColocationUser;
use App\Models\User;
use App\Models\Colocation;
use App\enum\InvitationStatus;
use Illuminate\Support\Str;

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

    public function create()
    {
        $colocations = Colocation::where('owner_id', auth()->id())->get();
        $users = User::where('id', '!=', auth()->id())->get();
        
        return view('invitations.create', compact('colocations', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'colocation_id' => 'required|exists:colocations,id',
            'email' => 'required|email|exists:users,email',
        ]);

        $receiver = User::where('email', $request->email)->first();
        
        if($receiver->id == auth()->id()) {
            return back()->with('error', 'You can not invite yourself.');
        }

        $alreadyMember = ColocationUser::where('colocation_id', $request->colocation_id)
            ->where('user_id', $receiver->id)
            ->exists();

        if ($alreadyMember) {
            return back()->with('error', 'User is already a member of this colocation.');
        }

        $alreadyInvited = Invitation::where('colocation_id', $request->colocation_id)
            ->where('receiver_id', $receiver->id)
            ->where('status', InvitationStatus::PENDING)
            ->exists();

        if ($alreadyInvited) {
            return back()->with('error', 'An invitation is already pending for this user.');
        }

        Invitation::create([
            'colocation_id' => $request->colocation_id,
            'sender_id' => auth()->id(),
            'receiver_id' => $receiver->id,
            'status' => InvitationStatus::PENDING,
            'token' => Str::random(32),
        ]);

        return redirect()->route('colocation.show', $request->colocation_id)
            ->with('success', 'Invitation sent successfully!');
    }

    public function accept(Invitation $invitation)
    {
        $invitation->update(['status' => InvitationStatus::ACCEPTED]);
        
        ColocationUser::create([
            'colocation_id' => $invitation->colocation_id,
            'user_id' => $invitation->receiver_id,
            'amount' => 0,
            'entry_date' => now(),
        ]);
        User::where('id', $invitation->receiver_id)->update([
            'role' => 'member',
        ]);
        
        return redirect()->route('colocation.show', $invitation->colocation)
            ->with('success', 'You have joined the colocation!');
    }

    public function decline(Invitation $invitation)
    {
        $invitation->update(['status' => InvitationStatus::REJECTED]);
        
        return redirect()->route('invitations.index')
            ->with('success', 'Invitation declined.');
    }
}
