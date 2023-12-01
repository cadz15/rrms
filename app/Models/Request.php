<?php

namespace App\Models;

use App\Enums\RequestStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function prettyStatus()
    {
        return RequestStatusEnum::from($this->status)->prettyStatus();
    }

    public function user()
    {
        return $this->belongs(User::class);
    }

    /**
     * Define a one-to-many relationship with RequestItem model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requestItems()
    {
        return $this->hasMany(RequestItem::class);
    }

    /**
     * Define a one-to-many relationship with Transaction model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

}
