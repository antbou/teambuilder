<?php

namespace Teambuilder\model;

use Teambuilder\model\DB;
use Teambuilder\model\Team;
use Teambuilder\model\Model;

class Member extends Model
{
    public $id = null;
    public $name;
    public $password;
    public $role_id;

    const DEFAULT = USER_ID;


    public function create(): bool
    {
        try {
            $this->id = DB::insert("INSERT INTO members(id, name,password,role_id) VALUES (:id, :name, :password, :role_id)", ['id' => $this->id, 'name' => $this->name, 'password' => $this->name . "'s_Pa$\$w0rd", 'role_id' => $this->role_id]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static function make(array $params)
    {
        $member = new Member();

        $member->id = (isset($params['id'])) ? $params['id'] : null;
        $member->name = $params['name'];
        $member->role_id = $params['role_id'];

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

    public function save(): bool
    {
        try {
            return DB::execute("UPDATE members set name = :name, role_id = :role_id WHERE id = :id", ['id' => $this->id, 'name' => $this->name, 'role_id' => $this->role_id]);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function delete(): bool
    {
        return self::destroy($this->id);
    }

    static function destroy(int $id): bool
    {
        try {
            DB::execute("DELETE FROM members WHERE id = :id", ['id' => $id]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function teams()
    {
        $teams = [];

        foreach (DB::selectMany("SELECT teams.id, teams.name, teams.state_id FROM teams INNER JOIN team_member ON team_member.team_id = teams.id WHERE team_member.member_id = :id ORDER BY teams.name ASC", ['id' => $this->id]) as $team) {
            $teams[] = Team::make($team);
        }

        return $teams;
    }
}
