<?php

namespace Teambuilder\model;

use Teambuilder\model\DB;
use Teambuilder\model\Team;
use Teambuilder\model\Model;

class Member extends Model
{
    public $id;
    public $name;
    public $password;
    public $role_id;

    const DEFAULT = USER_ID;

    static function make(array $params)
    {
        $member = new Member();
        $member->id = (isset($params['id'])) ? $params['id'] : null;
        $member->name = $params['name'];
        $member->role_id = $params['role_id'];
        $member->password = $member->name . "'s_Pa$\$w0rd";

        return $member;
    }

    static function all(): array
    {
        $res = [];

        foreach (DB::selectMany("SELECT * FROM members ORDER BY members.name ASC", []) as $member) {
            $res[] = self::make($member);
        }

        return $res;
    }

    static function find(int $id): ?Member
    {
        $res = DB::selectOne("SELECT * FROM members where id = :id", ['id' => $id]);
        return ($res) ? self::make($res) : null;
    }

    public static function where(string $param, $value): array
    {
        $res = [];

        foreach (DB::selectMany("SELECT * FROM members where $param = :$param", [$param => $value]) as $member) {
            $res[] = self::make($member);
        }

        return $res;
    }

    public function teams(): array
    {
        $teams = [];

        foreach (DB::selectMany("SELECT teams.id, teams.name, teams.state_id FROM teams INNER JOIN team_member ON team_member.team_id = teams.id WHERE team_member.member_id = :id ORDER BY teams.name ASC", ['id' => $this->id]) as $team) {
            $teams[] = Team::make($team);
        }

        return $teams;
    }
}
