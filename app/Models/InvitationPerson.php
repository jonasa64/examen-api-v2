<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationPerson extends Model
{
    use HasFactory;

    protected $table = 'invitation_people';
    protected $guarded = [];

    public function invitations()
    {
        return $this->belongsTo(Invitation::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
