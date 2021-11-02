<?php

namespace Teambuilder\controller;

use Teambuilder\model\Role;
use Teambuilder\core\services\Http;

class ModeratorController
{
    public function showAll()
    {
        Http::response('moderator/showAll', ['modo' => Role::find(Role::MODO)->members()]);
    }
}
