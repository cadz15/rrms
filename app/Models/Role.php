<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function scopeAdmin(Builder $query) : void
    {
        $query->where('name', RoleEnum::ADMIN);
    }

    public function scopeRegistrar(Builder $query) : void
    {
        $query->where('name', RoleEnum::REGISTRAR);
    }

    public function scopeStudent(Builder $query) : void
    {
        $query->where('name', RoleEnum::STUDENT);
    }
}
