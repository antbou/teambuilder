<?php

namespace Teambuilder\core;

use Teambuilder\model\Member;

class Autologin
{
    static public function login()
    {
        $_SESSION['membre'] = Member::find(Member::DEFAULT);
    }
}
