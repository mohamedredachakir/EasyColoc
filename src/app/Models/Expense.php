<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Colocation;
use App\Models\User;
use App\Models\Category;


class Expense extends Model
{
    protected $fillable = [
        'name',
        'colocation_id',
        'category_id',
        'user_id',
        'amount',
        'expense_date',
    ];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
