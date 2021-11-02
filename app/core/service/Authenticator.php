<?php

namespace Teambuilder\core\service;

use Teambuilder\model\Member;

class Authenticator
{
    static public function autologin()
    {
        $_SESSION['member'] = Member::find(Member::DEFAULT);
    }
}
