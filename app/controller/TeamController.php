<?php

namespace Teambuilder\controller;

use Teambuilder\core\Render;
use Teambuilder\model\Team;

class TeamController
{
    public function list()
    {
        Render::render('team/list', ['teams' => Team::all()]);
    }
}
