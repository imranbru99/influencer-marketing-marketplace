<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTag extends Model
{
    use HasFactory;
    public function tagName(){
        return $this->belongsTo(Tag::class,'tag_id');
    }
}
