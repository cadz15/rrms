<?php

namespace App\Models;

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

    public function prettyIsGraduated()
    {
        return match($this->is_graduated) {
            '0' => 'No',
            '1' => 'Yes',
            default => 'No'
        };
    }
}
