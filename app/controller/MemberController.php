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

    public function profile()
    {
        if (!isset($_GET['id'])) {
            return Http::notFoundException();
        }

        $member = Member::find($_GET['id']);

        if (is_null($member)) {
            return Http::notFoundException();
        }
    }
}
