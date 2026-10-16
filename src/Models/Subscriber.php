<?php

namespace Sesuva\Newsletter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Subscriber extends Model
{
    protected $table = 'newsletter_subscribers';

    protected $fillable = [
        'email',
        'name',
        'is_subscribed',
        'subscribed_at',
        'unsubscribed_at',
        'verification_token',
        'verified_at',
    ];

    protected $casts = [
        'is_subscribed' => 'boolean',
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Subscriber $subscriber) {
            if (empty($subscriber->verification_token)) {
                $subscriber->verification_token = \Illuminate\Support\Str::random(40);
            }
        });
    }

    public function scopeSubscribed(Builder $query): Builder
    {
        return $query->where('is_subscribed', true)
            ->whereNotNull('verified_at');
    }

    public function scopeByEmail(Builder $query, string $email): Builder
    {
        return $query->where('email', $email);
    }

    public function subscribe(): void
    {
        $this->update([
            'is_subscribed' => true,
            'subscribed_at' => now(),
        ]);
    }

    public function unsubscribe(): void
    {
        $this->update([
            'is_subscribed' => false,
            'unsubscribed_at' => now(),
        ]);
    }

    public function verify(): void
    {
        $this->update([
            'verified_at' => now(),
            'verification_token' => null,
        ]);
    }

    public function isVerified(): bool
    {
        return $this->verified_at !== null;
    }

    public function isActive(): bool
    {
        return $this->is_subscribed && $this->isVerified();
    }
}
