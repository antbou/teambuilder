<?php

namespace Teambuilder\model;

use Teambuilder\model\DB;
use Teambuilder\model\Model;
use Teambuilder\model\Member;

class Team extends Model
{
    public $id;
    public $name;
    public $state_id;

    protected string $table;

    public function __construct()
    {
        $this->table = self::getShortName(self::class);
    }

    /**
     * Create and return a Team object
     *
     * @param integer $id
     * @param string $name
     * @param integer $state_id
     * @return Team|null
     */
    public static function make(array $params): Team
    {
        $team = new Team();

        $team->id = (isset($params['id'])) ? $params['id'] : null;
        $team->name = $params['name'];
        $team->state_id = $params['state_id'];

        return $team;
    }

    /**
     * Create an object from the data retrieved from the database identified by the ID of the desired object
     *
     * @param integer $id
     * @return Team|null
     */
    public static function find(int $id): ?Team
    {
        $res = DB::selectOne("SELECT * FROM teams where id = :id", ['id' => $id]);

        return ($res) ? self::make($res) : null;
    }

    /**
     * return all teams
     *
     * @return array
     */
    public static function all(): array
    {
        $res = [];

        // Create an array of objects
        foreach (DB::selectMany("SELECT * FROM teams ORDER BY teams.name ASC", []) as $team) {
            $res[] = self::make($team);
        }

        return $res;
    }

    /**
     * Gets all the team members
     *
     * @return array
     */
    public function members(): array
    {

        $res = DB::selectMany("SELECT members.id, members.name, members.role_id FROM members INNER JOIN team_member ON team_member.member_id = members.id WHERE team_member.team_id = :id", ['id' => $this->id]);
        $members = [];

        // Create an array of objects
        foreach ($res as $member) {
            $members[] = Member::make($member);
        }

        return $members;
    }

    public static function destroy(int $id, string $table = null): bool
    {
        $table = self::getShortName(self::class);
        return parent::destroy($id, $table);
    }

    /**
     * Gets the team's captain
     *
     * @return Member|null
     */
    public function captain(): ?Member
    {
        $res = DB::selectOne("SELECT members.id, members.name, members.role_id FROM members INNER JOIN team_member ON team_member.member_id = members.id WHERE team_member.is_captain = 1 AND team_member.team_id = :id", ['id' => $this->id]);

        return ($res) ? Member::make($res) : null;
    }


    public function addMember(Member $member, int $membershipType = MembershipType::active, bool $isCaptain = false): bool
    {

        $query = "INSERT INTO teambuilder.team_member (member_id, team_id, membership_type, is_captain) VALUES (:member_id, :team_id, :membership_type, :is_captain)";

        $params = [
            'member_id' => $member->id,
            'team_id' => $this->id,
            'membership_type' => $membershipType,
            'is_captain' => +$isCaptain
        ];

        try {
            DB::insert($query, $params);
            return true;
        } catch (\PDOException $ex) {
            return false;
        }
    }
}
