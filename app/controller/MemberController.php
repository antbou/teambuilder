<?php

namespace Teambuilder\controller;

use Teambuilder\model\Member;
use Teambuilder\core\service\Http;
use Teambuilder\controller\AbstractController;

class MemberController extends AbstractController
{
    public function list()
    {
        Http::response('member/list', ['members' => Member::all()]);
    }
}
