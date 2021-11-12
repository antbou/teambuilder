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
        return Http::response('team/listAll', ['teams' => Team::all(order: 'name')]);
    }

    public function list()
    {
        return Http::response('team/list', ['teams' => Member::find(Member::DEFAULT)->teams()]);
    }

    public function show()
    {
        if (!isset($_GET['id'])) {
            return Http::notFoundException();
        }

        // Default ID = 1
        $id = !intval($_GET['id']) ? 1 : intval($_GET['id']);

        if (is_null(Team::find($id))) {
            $id = 1;
        }

        return Http::response('team/showTeam', ['team' => Team::find($id)]);
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
                return Http::redirectToUrl("/?controller=team&task=show&id=$team->id");
            } else {
                $form->getFields()['title']->error = "Cette équipe existe déjà !";
            }
        }

        return Http::response('team/createTeam', ['fields' => $form->getFields()], true);
    }
}
