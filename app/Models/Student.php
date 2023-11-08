<?php

namespace App\Models;

use App\Traits\NameTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, NameTrait;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prettyTextIsGraduated()
    {
        return $this->is_graduated ? 'Yes' : 'False';
    }
}
