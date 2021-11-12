<?php

namespace Teambuilder\controller;

use Teambuilder\core\controller\AbstractController;
use Teambuilder\model\Role;
use Teambuilder\core\service\Http;

class ModeratorController extends AbstractController
{
    public function showAll()
    {
        return Http::response('moderator/showAll', ['modo' => Role::find(Role::MODO)->members()]);
    }
}
