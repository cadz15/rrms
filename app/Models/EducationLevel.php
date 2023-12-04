<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function majors() {
        return $this->hasMany(Major::class, 'education_level_id');
    }
}
