<?php

namespace App\Models;

use Core\Lib\Model;

class User extends Model
{

    protected static string $table = 'users';
    protected static array $fields = [
        'id',
        'name',
        'email',
        'password'
    ];
}