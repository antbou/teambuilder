<?php

namespace Teambuilder\controller;

use Teambuilder\core\Render;
use Teambuilder\model\Member;
use Teambuilder\controller\AbstractController;

class MemberController extends AbstractController
{
    public function list()
    {
        Render::render('member/list', ['members' => Member::all()]);
    }
}
