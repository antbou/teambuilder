<?php

namespace Teambuilder\model;

use Teambuilder\model\DB;
use Teambuilder\model\Model;

class Role extends Model
{
    public $id;
    public $slug;
    public $name;

    const MODO = 2;

    protected string $table;

    public function __construct()
    {
        $this->table = self::getShortName(self::class);
    }

    static function make(array $fields): Role // create object, but no db record
    {
        $role = new Role();
        $role->id = (isset($fields['id'])) ? $fields['id'] : null;
        $role->slug = $fields["slug"];
        $role->name = $fields["name"];
        return $role;
    }

    static function find($id): ?Role
    {
        $db = DB::selectOne("SELECT * FROM roles where id = :id", ["id" => "$id"]);
        return ($db) ? self::make($db) : null;
    }

    static function all(): array
    {
        $res = [];

        // Create an array of objects
        foreach (DB::selectMany("SELECT * FROM roles", []) as $role) {
            $res[] = self::make($role);
        }

        return $res;
    }

    public static function destroy(int $id, string $table = null): bool
    {
        $table = self::getShortName(self::class);
        return parent::destroy($id, $table);
    }

    public function members()
    {
        $res = DB::selectMany("SELECT members.id, members.name, members.role_id FROM members WHERE members.role_id = :id ORDER BY members.name ASC", ['id' => $this->id]);
        $members = [];

        foreach ($res as $member) {
            $members[] = Member::make(['id' => $member['id'], 'name' => $member['name'], 'role_id' => $member['role_id']]);
        }

        return $members;
    }
}
