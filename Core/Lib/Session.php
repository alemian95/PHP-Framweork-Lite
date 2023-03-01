<?php

namespace Core\Lib;

use App\Models\User;

define('DEFAULT_GUARD', 'web');

class Session extends \Symfony\Component\HttpFoundation\Session\Session
{

    private $guards = [ 'web', 'cpa' ];

    private $users = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function user($guard = DEFAULT_GUARD)
    {
        return $this->users[$guard];
    }

    public function setUser(User $user, $guard = DEFAULT_GUARD)
    {
        $this->users[$guard] = $user;
    }

    public function unsetUser($guard = DEFAULT_GUARD)
    {
        unset($this->users[$guard]);
    }
}