<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function InvitationPerson()
    {
        return $this->hasMany(InvitationPerson::class);
    }

    public function isOwner()
    {
        return auth()->id() == $this->user_id;
    }
}
