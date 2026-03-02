<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Colocation;
use App\Models\User;

class ColocationUser extends Model
{
    protected $fillable = [
        'colocation_id',
        'user_id',
        'amount',
        'entry_date',
        'exit_date',
    ];


    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
