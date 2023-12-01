<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use HasFactory;

    protected $fillable = ['education_level_id', 'name'];


    public function education_level() {
        return $this->belongsTo(EducationLevel::class, 'id');
    }
}
