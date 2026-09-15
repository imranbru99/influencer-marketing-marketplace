<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    use HasFactory;
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function influencer() {
        return $this->belongsTo(Influencer::class, 'influencer_id');
    }
    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function hiring() {
        return $this->belongsTo(Hiring::class, 'hiring_id');
    }
    public function service() {
        return $this->belongsTo(Service::class, 'service_id');
    }

}
