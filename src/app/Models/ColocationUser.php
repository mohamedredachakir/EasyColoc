<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ColocationUser extends Pivot
{
    protected $table = 'colocation_user';

    protected $fillable = [
        'colocation_id',
        'user_id',
        'joined_at',
        'left_at',
    ];

    protected $dates = [
        'joined_at',
        'left_at',
    ];
}