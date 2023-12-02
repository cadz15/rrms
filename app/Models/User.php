<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RoleEnum;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notification;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeStudents(Builder $query)
    {
        $query->whereHas('role', fn ($subQuery) => $subQuery->student());
    }

    public function scopeApprovedStudents(Builder $query)
    {
        $query->whereHas('role', fn ($subQuery) => $subQuery->student())
            ->where('is_approved', true)->whereNotNull('approved_by');
    }

    public function scopeRegistrars(Builder $query)
    {
        $query->whereHas('role', fn ($subQuery) => $subQuery->registrar());
    }

    public function scopeAdmins(Builder $query)
    {
        $query->whereHas('role', fn ($subQuery) => $subQuery->admin());
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function candidates()
    {
        return $this->hasMany(User::class, 'approved_by', 'id');
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function routeNotificationForVonage(Notification $notification)
    {
        return $this->contact_number;
    }

    public function fullName()
    {
        return $this->last_name . ', ' . $this->first_name . ' ' . $this->middle_name;
    }
}
