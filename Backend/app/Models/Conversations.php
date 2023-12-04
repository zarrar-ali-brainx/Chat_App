<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversations extends Model
{
    public $timestamps=false;
    use HasFactory;
    protected $fillable = ['type','user1_id','user2_id','group_name','creator_id'];
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function userOne()
    {
        return $this->belongsTo(User::class,'user1_id','id');
    }
    public function userTwo()
    {
        return $this->belongsTo(User::class,'user2_id','id');
    }
}
