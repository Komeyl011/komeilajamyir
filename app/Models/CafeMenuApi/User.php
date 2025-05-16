<?php

namespace App\Models\CafeMenuApi;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $table = 'api_users';

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

    // Mutator for phone_number
    public function setPhoneNumberAttribute($value)
    {
        // Normalize the phone number by removing +98 or leading 0
        if (str_starts_with($value, '+98')) {
            $this->attributes['phone_number'] = substr($value, 3);
        } elseif (str_starts_with($value, '0')) {
            $this->attributes['phone_number'] = substr($value, 1);
        } else {
            $this->attributes['phone_number'] = $value; // Store as is if no prefix
        }
    }
}
