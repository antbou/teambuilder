<?php

namespace Teambuilder\controller;

use Exception;
use Teambuilder\model\Team;
use Teambuilder\core\Render;

class TeamController
{
    public function list()
    {
        Render::render('team/list', ['teams' => Team::all()]);
    }

    public function show()
    {
        if (!isset($_GET['id'])) {
            http_response_code(404);
            die;
        }
        // Default ID = 1
        $id = !intval($_GET['id']) ? 1 : intval($_GET['id']);

        if (is_null(Team::find($id))) {
            $id = 1;
        }

        Render::render('team/show', ['team' => Team::find($id)]);
    }
}
