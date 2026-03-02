<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Colocation;
use App\Models\User;

class Invitation extends Model
{
    protected $fillable = [
        'colocation_id',
        'sender_id',
        'receiver_id',
        'status',
        'token',
    ];

    protected $casts = [
        'status' => \App\enum\InvitationStatus::class,
    ];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
