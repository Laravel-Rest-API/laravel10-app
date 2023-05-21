<?php

namespace App\Responses;

class UserResponse
{
    public const SUCCESS = [
        'code' => 200,
        'message' => 'User Get Successfully',
    ];

    public const CREATED = [
        'code' => 201,
        'message' => 'User Created Successfully',
    ];

    public const UPDATED = [
        'code' => 200,
        'message' => 'User Updated Successfully',
    ];

    public const DELETED = [
        'code' => 200,
        'message' => 'User Deleted Successfully',
    ];
}
