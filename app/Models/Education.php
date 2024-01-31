<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'educations';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function prettyIsGraduated()
    {
        return match ($this->is_graduated) {
            0 => 'No',
            1 => 'Yes',
            default => 'No'
        };
    }

    public function scopeToApiData(Builder $query, $studentId) {
        return $query->with('major', function($subQuery) {
            return $subQuery->with('educationLevel');
        })
        ->where('user_id', $studentId)
        ->get()
        ->transform(function($education) {
            return [
                'id' => $education->id,
                'degree' => $education->major->name,
                'educationLevel' => $education->major->educationLevel->name,
                'schoolName' => $education->school_name,
                'schoolAddress' => $education->school_address,
                'isGraduate' => boolval($education->is_graduated),
                'yearStart' => $education->year_start? Carbon::parse($education->year_start)->format('F d, Y') : null,
                'yearEnd' => $education->year_end? Carbon::parse($education->year_end)->format('F d, Y') : null,
                'level' => (int) $education->year_level?? 0,
            ];
        });
    }
}
