<?php

namespace Teambuilder\model;

use Teambuilder\model\Team;
use Teambuilder\core\model\DB;
use Teambuilder\core\model\Model;

class Member extends Model
{
    public $id;
    public $name;
    public $password;
    public $role_id;
    public $status_id;

    const DEFAULT = USER_ID;
    const CAPTAIN = 1;

    static function make(array $params)
    {
        $member = new Member();
        $member->id = (isset($params['id'])) ? $params['id'] : null;
        $member->name = $params['name'];
        $member->role_id = $params['role_id'];
        $member->password = $member->name . "'s_Pa$\$w0rd";

        return $member;
    }

    public function teams(): array
    {
        $query = 'SELECT teams.id, teams.name, teams.state_id FROM teams INNER JOIN team_member ON team_member.team_id = teams.id WHERE team_member.member_id = :id ORDER BY teams.name';
        return DB::selectMany(
            $query,
            ['id' => $this->id],
            Team::class
        );
    }

    public function teamsCaptain(): array
    {
        $query = "SELECT teams.* from teams INNER JOIN team_member ON team_member.team_id = teams.id WHERE team_member.member_id = :id AND team_member.is_captain = 1";

        return DB::selectMany(
            $query,
            ['id' => $this->id],
            Team::class
        );
    }

    public function getRole()
    {
        return Role::find($this->role_id);
    }

    public function getStatus()
    {
        return Status::find($this->status_id);
    }
}
