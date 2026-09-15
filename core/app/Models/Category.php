<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function influencers()
    {
        return $this->belongsToMany(Influencer::class, 'influencer_categories');
    }

    public function service(){
        return $this->hasMany(Service::class,'category_id');
    }

    public function scopeActive() {
        return $this->where('status', 1);
    }
}
