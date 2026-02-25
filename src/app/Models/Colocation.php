<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
     protected $fillable = [
        'name',
        'owner_id',
        'status',
    ];

    public function owner() { return $this->belongsTo(User::class, 'owner_id'); }
    public function users() { return $this->belongsToMany(User::class, 'colocation_users')->withTimestamps()->withPivot('joined_at','left_at'); }
    public function expenses() { return $this->hasMany(Expense::class); }
    public function categories() { return $this->hasMany(Category::class); }
    public function invitations() { return $this->hasMany(Invitation::class); }
    public function payments() { return $this->hasMany(Payment::class); }
}
