<?php

namespace Teambuilder\controller;

use Teambuilder\model\Role;
use Teambuilder\model\Member;
use Teambuilder\model\Status;
use Teambuilder\core\form\Field;
use Teambuilder\core\service\Http;
use Teambuilder\core\form\FormValidator;
use Teambuilder\core\controller\AbstractController;

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

    public function edit()
    {
        if (!isset($_GET['id'])) {
            return Http::notFoundException();
        }

        $member = Member::find($_GET['id']);

        if (is_null($member)) {
            return Http::notFoundException();
        }

        $isModo = ($_SESSION['member']->getRole() == Role::where('slug', 'MOD')[0]);
        $success = null;
        $form = new FormValidator('member');
        $form->addField(['name' => new Field('name', 'string', false)]);

        if ($form->process() && $this->csrfValidator()) { // if form is submit and csrf valid

            $member->name = $form->getFields()['name']->value;


            if ($member->save()) { // redirect if success
                $success = "Modification réussi !";
            } else {
                $form->getFields()['name']->error = "Nom déjà existant !";
            }
        }
        return Http::response('member/edit', ['member' => $member, 'fields' => $form->getFields(), 'success' => $success, 'isModo' => $isModo], true);
    }
}
