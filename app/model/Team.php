<?php

namespace Teambuilder\model;

use Teambuilder\model\DB;
use Teambuilder\model\Model;
use Teambuilder\model\Member;

class Team extends Model
{
    public $id = null;
    public $name;
    public $state_id;

    /**
     * sauvegarde l'objet en bdd
     *
     * @return void
     */
    public function create(): bool
    {
        $check = DB::selectOne("SELECT * FROM teams WHERE NAME = :name", ['name' => $this->name]);

        // Si "name" existe, alors return false
        if (!empty($check)) {
            return false;
        }

        $this->id = DB::insert("INSERT INTO teams(name,state_id) VALUES (:name, :state_id)", ['name' => $this->name, 'state_id' => $this->state_id]);

        return true;
    }

    public static function addMember(array $params): bool
    {
        $check = DB::selectOne("SELECT * FROM teambuilder.team_member WHERE member_id = :member_id and team_id = :team_id and membership_type = :membership_type and is_captain = :is_captain", [
            'member_id' => $params['member_id'],
            'team_id' => $params['team_id'],
            'membership_type' => $params['membership_type'],
            'is_captain' => $params['is_captain']
        ]);

        // Si "name" existe, alors return false
        if (!empty($check)) {
            return false;
        }

        return DB::insert('INSERT INTO teambuilder.team_member (member_id, team_id, membership_type, is_captain) VALUES (:member_id, :team_id, :membership_type, :is_captain)', [
            'member_id' => $params['member_id'],
            'team_id' => $params['team_id'],
            'membership_type' => $params['membership_type'],
            'is_captain' => $params['is_captain']
        ]);
    }

    /**
     * Créé et return un objet Team
     *
     * @param integer $id
     * @param string $name
     * @param integer $state_id
     * @return Team|null
     */
    public static function make(array $params): Team
    {
        $team = new Team();

        if (isset($params['id'])) {
            $team->id = $params['id'];
        }

        $team->name = $params['name'];
        $team->state_id = $params['state_id'];

        return $team;
    }

    /**
     * Créé un objet à partir des données récupérées de la base de données identifiée par l'ID de l'objet souhaité
     *
     * @param integer $id
     * @return Team|null
     */
    public static function find(int $id): ?Team
    {
        $res = DB::selectOne("SELECT * FROM teams where id = :id", ['id' => $id]);

        // Si le tableau ne contient pas l'index, return null
        if (!$res) {
            return null;
        }

        return self::make(['id' => $res['id'], 'name' => $res['name'], 'state_id' => $res['state_id']]);
    }

    /**
     * Retourne un tableau d'objet teams
     *
     * @return array
     */
    public static function all(): array
    {
        $res = [];

        foreach (DB::selectMany("SELECT * FROM teams ORDER BY teams.name ASC", []) as $index) {
            $res[] = self::make(['id' => $index['id'], 'name' => $index['name'], 'state_id' => $index['state_id']]);
        }

        return $res;
    }

    /**
     * Enregistre l'objet en base de donnée
     *
     * @return boolean
     */
    public function save(): bool
    {

        $check = DB::selectOne("SELECT * FROM teams WHERE NAME = :name", ['name' => $this->name]);

        // si le tableau n'est pas vide, alors return false car le nom sera dupliqué
        if (!empty($check)) {
            return false;
        }

        return DB::execute("UPDATE teams set name = :name, state_id = :state_id WHERE id = :id", ['id' => $this->id, 'name' => $this->name, 'state_id' => $this->state_id]);
    }

    /**
     * Supprime l'objet de la base de données
     *
     * @return boolean
     */
    public function delete(): bool
    {
        return self::destroy($this->id);
    }

    /**
     * Supprime un objet de la base de donnée via son ID
     *
     * @param integer $id
     * @return boolean
     */
    public static function destroy(int $id): bool
    {
        try {
            DB::execute("DELETE FROM teams WHERE id = :id", ['id' => $id]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function members(): array
    {
        $res = DB::selectMany("SELECT members.id, members.name, members.role_id FROM members INNER JOIN team_member ON team_member.member_id = members.id WHERE team_member.team_id = :id", ['id' => $this->id]);
        $members = [];

        foreach ($res as $member) {
            $members[] = Member::make(['id' => $member['id'], 'name' => $member['name'], 'role_id' => $member['role_id']]);
        }

        return $members;
    }

    public function captain(): ?Member
    {

        $res = DB::selectOne("SELECT members.id, members.name, members.role_id FROM members INNER JOIN team_member ON team_member.member_id = members.id WHERE team_member.is_captain = 1 AND team_member.team_id = :id", ['id' => $this->id]);

        if (!$res) {
            return null;
        }

        return Member::make($res);
    }
}
