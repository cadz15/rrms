<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Student;
use App\Models\User;

class StudentService
{
    public function create(array $studentData)
    {
        $roleId = Role::student()->first();
        $studentData['role_id'] = $roleId;
        return User::create($studentData);
    }
}
