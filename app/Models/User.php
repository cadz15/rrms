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
    use HasFactory, Notifiable;

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

    // changed into attribute
    public function getFullNameLastNameFirstAttribute()
    {
        $middleInitial = empty($this->middle_name) ? '' : ' ' . $this->middle_name[0] . '.';
        $suffix = empty($this->suffix) ? '' : " , " . $this->suffix;

        return $this->last_name . ', ' . $this->first_name . $middleInitial . $suffix;
    }

    // changed into attribute
    public function getFullNameAttribute()
    {
        $middleInitial = empty($this->middle_name) ? '' : ' ' . $this->middle_name[0] . '. ';
        $suffix = empty($this->suffix) ? '' : " " . $this->suffix;

        return $this->first_name . $middleInitial . $this->last_name . $suffix;
    }


    public function getLatestEducationLevelAttribute()
    {
        if ($this->educations->isEmpty()) {
            return '';
        }

        $latestEducation = $this->educations->sortByDesc('year_start')->first();

        return $latestEducation->degree . ' - ' . $latestEducation->major;
    }

    public function getPrettyTextIsGraduatedAttribute()
    {
        if ($this->educations->isEmpty()) {
            return '';
        }

        $latestEducation = $this->educations->sortByDesc('year_start')->first();

        if ($latestEducation->is_graduated) {
            return '<span class="badge bg-label-primary me-1">Graduate</span>';
        }

        return '<span class="badge bg-label-warning me-1">Not Graduate</span>';
    }

    public function getLatestEducation()
    {
        return $this->educations->sortByDesc('year_end')->first();
    }

    public function getMajorNameAttribute()
    {
        return $this->getLatestEducation()->major->name;
    }

    public function isAdmin()
    {
        return Role::where('name', RoleEnum::ADMIN->value)->where('id', $this->role_id)->exists();
    }

    public function isRegistrar()
    {
        return Role::where('name', RoleEnum::REGISTRAR->value)->where('id', $this->role_id)->exists();
    }

    public function isStudent()
    {
        return Role::where('name', RoleEnum::STUDENT->value)->where('id', $this->role_id)->exists();
    }
}
