<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Conversations started by this customer
    public function customerConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'customer_id');
    }

    // Conversations assigned to this support agent
    public function assignedConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'agent_id');
    }

    // Messages sent by this user
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    public function savedReceivers(): HasMany
    {
        return $this->hasMany(SavedReceiver::class);
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    public function assignedFraudCases(): HasMany
    {
        return $this->hasMany(FraudCase::class, 'assigned_to');
    }
}
}