<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Invitation;

class Colocation extends Model
{
    protected $fillable = [
        'name',
        'owner_id',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'colocation_users')
                    ->withPivot(['amount', 'entry_date', 'exit_date'])
                    ->withTimestamps();
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
