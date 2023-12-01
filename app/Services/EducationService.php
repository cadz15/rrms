<?php

namespace App\Services;

use App\Models\Education;
use App\Models\User;

class EducationService
{
    public function create(User $user, array $educationData)
    {
        $educationData['user_id'] = $user->id;

        return Education::create($educationData);
    }
}
