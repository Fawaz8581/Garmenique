<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'country_code',
        'phone_number',
        'address',
        'city',
        'postal_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get messages sent by the user
     */
    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'from_user_id');
    }

    /**
     * Get messages received by the user
     */
    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }

    /**
     * Get all messages (sent and received)
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'from_user_id')
                    ->orWhere('to_user_id', $this->id);
    }
}