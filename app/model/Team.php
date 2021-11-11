<?php

namespace Teambuilder\model;

use Teambuilder\model\Member;
use Teambuilder\core\model\DB;
use Teambuilder\core\model\Model;

class Team extends Model
{
    public $id;
    public $name;
    public $state_id;

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
     * Gets all the team members
     *
     * @return array
     */
    public function members(): array
    {
        $query = 'SELECT members.id, members.name, members.role_id FROM members INNER JOIN team_member ON team_member.member_id = members.id INNER JOIN teams ON teams.id = team_member.team_id WHERE team_member.team_id = :id ORDER BY members.name';
        return DB::selectMany($query, ['id' => $this->id], Member::class);
    }

    /**
     * Gets the team's captain
     *
     * @return Member|null
     */
    public function captain(): ?Member
    {
        $captain = Member::CAPTAIN;
        $query = "SELECT members.id, members.name, members.password, members.role_id FROM members INNER JOIN team_member ON team_member.member_id = members.id WHERE team_member.is_captain = {$captain} AND team_member.team_id = :id";

        return DB::selectOne($query, ['id' => $this->id], Member::class);
    }

    /**
     * add a member to the team
     *
     * @param Member $member
     * @param [type] $membershipType
     * @param boolean $isCaptain
     * @return boolean
     */
    public function addMember(Member $member, int $membershipType = MembershipType::active, bool $isCaptain = false): bool
    {
        $query = 'INSERT INTO teambuilder.team_member (member_id, team_id, membership_type, is_captain) VALUES (:member_id, :team_id, :membership_type, :is_captain)';
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
