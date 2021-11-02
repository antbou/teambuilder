<?php

namespace Teambuilder\controller;


use Teambuilder\model\Team;
use Teambuilder\model\Member;
use Teambuilder\core\form\Field;
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
            Http::notFoundException();
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


        if ($form->process() && $this->csrfValidator()) {

            $team = new Team();
            $team->name = $form->getFields()['title']->value;
            $team->state_id = 1;

            if ($team->create() && Team::addMember(['member_id' => $_SESSION['member']->id, 'team_id' => $team->id, 'membership_type' => 1, 'is_captain' => 1])) {
                Http::redirectToUrl("/?controller=team&task=show&id=$team->id");
            } else {
                $form->getFields()['title']->error = "Cette équipe existe déjà !";
            }
        }

        Http::response('team/createTeam', ['fields' => $form->getFields()], true);
    }
}
