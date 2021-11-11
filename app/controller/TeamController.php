<?php

namespace Teambuilder\controller;

use Teambuilder\model\Team;
use Teambuilder\model\State;
use Teambuilder\model\Member;
use Teambuilder\core\form\Field;
use Teambuilder\core\service\Http;
use Teambuilder\core\form\FormValidator;
use Teambuilder\core\controller\AbstractController;

class TeamController extends AbstractController
{
    public function listAll()
    {
        Http::response('team/listAll', ['teams' => Team::all(order: 'name')]);
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

        if ($form->process() && $this->csrfValidator()) { // if form is submit and csrf valid

            $team = Team::make(
                [
                    'name' => $form->getFields()['title']->value,
                    'state_id' => State::where('slug', 'WAIT_CHANG')[0]->id
                ]
            );

            if ($team->create() && $team->addMember($_SESSION['member'], isCaptain: true)) { // redirect if success
                Http::redirectToUrl("/?controller=team&task=show&id=$team->id");
            } else {
                $form->getFields()['title']->error = "Cette équipe existe déjà !";
            }
        }

        Http::response('team/createTeam', ['fields' => $form->getFields()], true);
    }
}
