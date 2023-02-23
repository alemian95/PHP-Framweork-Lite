<?php

namespace App\Models;

use Core\Lib\Model;

class User extends Model
{

    protected static string $table = 'users';
    protected static array $fields = [
        'id',
        'first_name',
        'last_name',
        'email',
        'password'
    ];
}