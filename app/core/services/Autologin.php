<?php

namespace Teambuilder\core\services;

use Teambuilder\model\Member;

class Autologin
{
    static public function login()
    {
        $_SESSION['member'] = Member::find(Member::DEFAULT);
    }
}
