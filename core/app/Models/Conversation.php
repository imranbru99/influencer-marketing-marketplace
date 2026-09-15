<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function influencer(){
        return $this->belongsTo(Influencer::class,'influencer_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function lastMessage(){
        return $this->hasOne(ConversationMessage::class,'conversation_id')->latestOfMany();
    }
    public function messages(){
        return $this->hasMany(ConversationMessage::class,'conversation_id')->latest();
    }
}
