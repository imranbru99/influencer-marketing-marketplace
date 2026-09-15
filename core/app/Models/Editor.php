<?php

namespace App\Models;
use Cache;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Editor extends Authenticatable {
    use HasFactory;

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'address'           => 'object',
        'kyc_data'          => 'object',
        'skills'            => 'object',
        'languages'         => 'array',
        'ver_code_send_at'  => 'datetime',
    ];

    public function categories() {
        return $this->belongsToMany(Category::class, 'influencer_categories');
    }


    public function isOnline() {
        return Cache::has('last_seen' . $this->id);
    }

    public function fullname(): Attribute {
        return new Attribute(
            get:fn() => $this->firstname . ' ' . $this->lastname,
        );
    }
    // SCOPES
    public function scopeActive() {
        return $this->where('status', 1);
    }
    public function scopeBanned() {
        return $this->where('status', 0);
    }

    public function scopeEmailUnverified() {
        return $this->where('ev', 0);
    }

    public function scopeMobileUnverified() {
        return $this->where('sv', 0);
    }

    public function scopeKycUnverified() {
        return $this->where('kv', 0);
    }

    public function scopeKycPending() {
        return $this->where('kv', 2);
    }

    public function scopeEmailVerified() {
        return $this->where('ev', 1);
    }

    public function scopeMobileVerified() {
        return $this->where('sv', 1);
    }

    public function scopeWithBalance() {
        return $this->where('balance', '>', 0);
    }
}
