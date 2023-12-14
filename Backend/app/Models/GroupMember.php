<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    public $timestamps=false;

    use HasFactory;

    protected $fillable = [
        'group_id',
        'user_id',
        'isAdmin',
        // Add other fields if needed
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversations::class, 'group_id');
    }
}
