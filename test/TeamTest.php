<?php

use Teambuilder\model\Team;
use Teambuilder\model\Member;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    /**
     * @covers Team::all()
     */
    public function testAll()
    {
        $this->assertEquals(15, count(Team::all()));
    }

    /**
     * @covers Team::find(id)
     */
    public function testFind()
    {
        $this->assertInstanceOf(Team::class, Team::find(1));
        $this->assertNull(Team::find(1000));
    }

    /**
     * @covers $team->create()
     */
    public function testCreate()
    {
        $team = new Team();
        $team->name = "XXX";
        $team->state_id = 1;
        $this->assertTrue($team->create());
        $this->assertFalse($team->create());
    }

    /**
     * @covers $team->save()
     */
    public function testSave()
    {
        $team = Team::find(1);
        $savename = $team->name;
        $team->name = "newname";
        $this->assertTrue($team->save());
        $this->assertEquals("newname", Team::find(1)->name);
        $team->name = $savename;
        $team->save();
    }

    /**
     * @covers $team->save() doesn't allow duplicates
     */
    public function testSaveRejectsDuplicates()
    {
        $team = Team::find(1);
        $team->name = Team::find(2)->name;
        $this->assertFalse($team->save());
    }

    /**
     * @covers $team->delete()
     */
    public function testDelete()
    {
        $team = Team::find(1);
        $this->assertFalse($team->delete()); // expected to fail because of foreign key
        $team = Team::make(["name" => "dummy", "state_id" => 1]);
        $this->assertTrue($team->create());
        $id = $team->id;
        $this->assertTrue($team->delete()); // expected to succeed
        $this->assertNull(Team::find($id)); // we should not find it back
    }

    /**
     * @covers Team::destroy(id)
     */
    public function testDestroy()
    {
        $this->assertFalse(Team::destroy(1)); // expected to fail because of foreign key
        $team = Team::make(["name" => "dummy", "state_id" => 1]);
        $team->create();
        $id = $team->id;
        $this->assertTrue(Team::destroy($id)); // expected to succeed
        $this->assertNull(Team::find($id)); // we should not find it back
    }

    /**
     * Assume the well-know dataset of 'teambuilder.sql'
     * @covers $member->teams()
     */
    public function testTeams()
    {
        $this->assertEquals(1, count(Member::find(3)->teams()));
        $this->assertEquals(0, count(Member::find(9)->teams()));
        $this->assertEquals(3, count(Member::find(10)->teams()));
    }

    /**
     * Assume the well-know dataset of 'teambuilder.sql'
     * @covers $team->members()
     */
    public function testMembers()
    {
        $this->assertEquals(3, count(Team::find(5)->members()));
        $this->assertEquals(0, count(Team::find(16)->members()));
        $this->assertEquals(4, count(Team::find(1)->members()));
    }

    /**
     * Assume the well-know dataset of 'teambuilder.sql'
     * @covers $team->captain()
     */
    public function testCaptain()
    {
        $team = Team::make(["name" => "dummy", "state_id" => 1]);
        $this->assertTrue($team->create());
        $this->assertNull($team->captain());
        $this->assertTrue($team->delete());
        $this->assertEquals(Member::find(1), Team::find(2)->captain());
        $this->assertNotEquals(Member::find(5), Team::find(2)->captain());
    }

    /**
     * Assume the well-know dataset of 'teambuilder.sql'
     * @covers $team->addMember()
     */
    public function testAddMember()
    {
        $team = Team::make(["name" => "dummy", "state_id" => 1]);
        $this->assertEquals(0, count($team->members()));
        $this->assertFalse($team->addMember(member::find(1))); // expected to failed because team is not stored in database
        $this->assertTrue($team->create());
        $this->assertTrue($team->addMember(member::find(1)));
        $this->assertFalse($team->addMember(member::find(1))); // expected to failed because this member already existe in the team
        $this->assertEquals(1, count($team->members()));
    }
}
