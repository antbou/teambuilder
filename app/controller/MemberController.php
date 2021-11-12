<?php

namespace Teambuilder\controller;

use Teambuilder\model\Member;
use Teambuilder\core\service\Http;
use Teambuilder\core\controller\AbstractController;
use Teambuilder\model\Role;
use Teambuilder\model\Status;

class MemberController extends AbstractController
{
    public function list()
    {
        $isModo = ($_SESSION['member']->getRole() == Role::where('slug', 'MOD')[0]);
        return Http::response('member/list', ['members' => Member::all(order: 'name'), 'isModo' => $isModo]);
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

        return Http::response('member/profile', ['member' => $member]);
    }
}
