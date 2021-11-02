<?php

namespace Teambuilder\controller;


use Teambuilder\model\Team;
use Teambuilder\model\Member;
use Teambuilder\core\form\Field;
use Teambuilder\core\services\Render;
use Teambuilder\core\form\FormValidator;
use Teambuilder\core\services\Http;

class TeamController extends AbstractController
{
    public function listAll()
    {
        Http::response('team/listAll', ['teams' => Team::all()]);
    }

    public function list()
    {
        Http::response('team/list', ['teams' => Member::find(Member::DEFAULT)->teams()]);
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

        Http::response('team/showTeam', ['team' => Team::find($id)]);
    }

    public function create()
    {
        $form = new FormValidator('team');
        $form->addField(['title' => new Field('title', 'string', false)]);

        // En cas d'erreur
        if ($form->process() && $this->csrfValidator()) {
        }


        Http::response('team/createTeam', ['fields' => $form->getFields()], true);
    }
}
