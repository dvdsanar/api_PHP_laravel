<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'message',
        'user_id',
        'channel_id'    
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parties()
    {
        return $this->belongsTo(Channel::class, 'party_id');
    }
}
