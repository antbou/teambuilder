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
        $check = DB::selectOne("SELECT * FROM members WHERE name = :name", ['name' => $this->name]);

        if (!empty($check)) {
            return false;
        }

        $this->id = DB::insert("INSERT INTO members(id, name,password,role_id) VALUES (:id, :name, :password, :role_id)", ['id' => $this->id, 'name' => $this->name, 'password' => $this->name . "'s_Pa$\$w0rd", 'role_id' => $this->role_id]);

        return true;
    }

    static function make(array $params)
    {
        $member = new Member();

        if (isset($params['id'])) {
            $member->id = $params['id'];
        }

        $member->name = $params['name'];
        $member->role_id = $params['role_id'];

        return $member;
    }

    static function all(): array
    {
        $res = [];

        foreach (DB::selectMany("SELECT * FROM members ORDER BY members.name ASC", []) as $index) {
            $res[] = self::make(['id' => $index['id'], 'name' => $index['name'], 'role_id' => $index['role_id']]);
        }

        return $res;
    }

    static function find(int $id): ?Member
    {
        $res = DB::selectOne("SELECT * FROM members where id = :id", ['id' => $id]);

        // Si le tableau ne contient pas l'index, return null
        if (!$res) {
            return null;
        }

        return self::make(['id' => $res['id'], 'name' => $res['name'], 'role_id' => $res['role_id']]);
    }

    public function save(): bool
    {
        $check = DB::selectOne("SELECT * FROM members WHERE name = :name", ['name' => $this->name]);

        // si il n'est pas vide, alors return false, car le nom sera dupliqué
        if (!empty($check)) {
            return false;
        }

        return DB::execute("UPDATE members set name = :name, role_id = :role_id WHERE id = :id", ['id' => $this->id, 'name' => $this->name, 'role_id' => $this->role_id]);
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
        $res = DB::selectMany("SELECT teams.id, teams.name, teams.state_id FROM teams INNER JOIN team_member ON team_member.team_id = teams.id WHERE team_member.member_id = :id ORDER BY teams.name ASC", ['id' => $this->id]);
        $teams = [];

        foreach ($res as $team) {
            $teams[] = Team::make(['id' => $team['id'], 'name' => $team['name'], 'state_id' => $team['state_id']]);
        }

        return $teams;
    }
}
