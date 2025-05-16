<?php

namespace App\Models;

 use App\Enum\YesNo;
 use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use \Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions;

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'timmy') {
            return $this->can('admin.access') || $this->can('admin.index');
//            dd($this->can('admin.access'));
        }
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return Storage::disk('liara')->url($this->avatar);
    }

    protected static function boot()
    {
        parent::boot();

        User::created(function ($user) {
            if (!$user->hasRole('user')) {
                $user->assignRole('user');
            }
        });
    }

    public function getEmailVerifiedAttribute()
    {
        return is_null($this->attributes['email_verified_at'])
            ? YesNo::NO
            : YesNo::YES;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'email_verified_at',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
