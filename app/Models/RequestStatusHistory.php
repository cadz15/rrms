<?php

namespace App\Models;

use App\Enums\RequestStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestStatusHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getFormattedDateCompletedAttribute() {
        return Carbon::parse($this->date_completed)->format('jS F');
    }

    public function getToHumanizedStatusAttribute() {
        return ucwords(strtolower(RequestStatusEnum::from($this->status)->prettyStatus()));
    }
}
