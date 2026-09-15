<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function influencer()
    {
        return $this->belongsTo(Influencer::class, 'influencer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'order_id')->latestOfMany();
    }

    public function orderMessage()
    {
        return $this->hasMany(OrderConversation::class, 'order_id')->latest();
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn () => $this->badgeData(),
        );
    }

    public function badgeData()
    {
        $html = '';

        if ($this->status == 0) {
            $html = '<span class="badge badge--secondary">' . trans('Pending') . '</span>';
        } elseif ($this->status == 1) {
            $html = '<span class="badge badge--success">' . trans('Completed') . '</span>';
        } elseif ($this->status == 2) {
            $html = '<span class="badge badge--primary">' . trans('Inprogress') . '</span>';
        } elseif ($this->status == 3) {
            $html = '<span class="badge badge--info">' . trans('Job Done') . '</span>';
        } elseif ($this->status == 4) {
            $html = '<span class="badge badge--warning">' . trans('Reported') . '</span>';
        } elseif ($this->status == 5) {
            $html = '<span class="badge badge--dark">' . trans('Cancelled') . '</span>';
        } elseif ($this->status == 6) {
            $html = '<span class="badge badge--danger">' . trans('Rejected') . '</span>';
        }

        return $html;
    }

    // SCOPES
    public function scopePaymentCompleted($query)
    {
        return $query->where('payment_status', 1);
    }

    public function scopePending()
    {
        return $this->where('payment_status', 1)->where('status', 0);
    }

    public function scopeCompleted()
    {
        return $this->where('payment_status', 1)->where('status', 1);
    }

    public function scopeInprogress()
    {
        return $this->where('payment_status', 1)->where('status', 2);
    }

    public function scopeJobDone()
    {
        return $this->where('payment_status', 1)->where('status', 3);
    }

    public function scopeReported()
    {
        return $this->where('payment_status', 1)->where('status', 4);
    }

    public function scopeCancelled()
    {
        return $this->where('payment_status', 1)->where('status', 5);
    }
    public function scopeRejected()
    {
        return $this->where('payment_status', 1)->where('status', 6);
    }
}
