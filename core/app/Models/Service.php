<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'key_points' => 'object',
    ];

    public function influencer(){
        return $this->belongsTo(Influencer::class,'influencer_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function gallery(){
        return $this->hasMany(ServiceGallery::class,'service_id');
    }

    public function completeOrder(){
        return $this->hasMany(Order::class,'service_id')->where('status',1);
    }

    public function totalOrder(){
        return $this->hasMany(Order::class,'service_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'service_tags');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'service_id');
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get:fn () => $this->badgeData(),
        );
    }

    public function badgeData(){
        $html = '';
        if($this->status == 0){
            $html = '<span class="badge badge--warning">'.trans('Pending').'</span>';
        }elseif($this->status == 1){
            $html = '<span><span class="badge badge--success">'.trans('Approved').'</span><br></span>';
        }elseif($this->status == 2){
            $html = '<span><span class="badge badge--danger">'.trans('Rejected').'</span><br></span>';
        }
        return $html;
    }

    public function scopePending()
    {
        return $this->where('status', 0);
    }

    public function scopeApproved()
    {
        return $this->where('status', 1)->whereHas('category',function($query){
            $query->where('status',1);
        })->whereHas('influencer',function($influencer){
            $influencer->where('status',1);
        });

    }

    public function scopeRejected()
    {
        return $this->where('status', 2);
    }

    public function scopeAvailable()
    {
        return $this->whereIn('status', [0,1]);
    }
}
