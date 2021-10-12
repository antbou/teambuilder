<?php

namespace Teambuilder\controller;

use Teambuilder\core\Render;
use Teambuilder\model\Member;
use Teambuilder\model\Role;

class ModeratorController
{
    public function showAll()
    {
        Render::render('moderator/showAll', ['modo' => Role::find(Role::MODO)->members()]);
    }
}
