<?php

namespace Teambuilder\controller;

use Teambuilder\model\Member;
use Teambuilder\core\service\Http;
use Teambuilder\core\controller\AbstractController;


class MemberController extends AbstractController
{
    public function list()
    {
        return Http::response('member/list', ['members' => Member::all(order: 'name')]);
    }
}
