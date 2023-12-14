<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $fillable = ['conv_id','sender_id','content', 'time'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function conversation()
    {
        return $this->belongsTo(Conversations::class, 'conv_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

}
