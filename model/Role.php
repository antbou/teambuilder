<?php

namespace Teambuilder\model;

use Teambuilder\model\DB;
use Teambuilder\model\Model;

class Role extends Model
{
    public $id;
    public $slug;
    public $name;

    static function make(array $fields): Role // create object, but no db record
    {
        $role = new Role();
        $role->id = $fields["id"];
        $role->slug = $fields["slug"];
        $role->name = $fields["name"];
        return $role;
    }

    public function create(): bool // create db record from object
    {
        try {
            return DB::insert("INSERT INTO roles(slug,name) VALUES (:slug, :name)", ["slug" => $this->slug, "name" => $this->name]);
        } catch (\PDOException $Exception) {
            return false;
        }
    }

    static function find($id): ?Role
    {
        $db = DB::selectOne("SELECT * FROM roles where id = :id", ["id" => "$id"]);
        return ($db) ? self::make($db) : null;
    }

    static function all(): array
    {

        return DB::selectMany("SELECT * FROM roles", []);;
    }

    public function save(): bool
    {
        try {
            return DB::execute("UPDATE roles set name = :name, slug = :slug WHERE id = :id", ["slug" => $this->slug, "name" => $this->name, "id" => $this->id]);
        } catch (\PDOException $Exception) {
            return false;
        }
    }

    public function delete(): bool
    {
        try {
            return DB::execute("DELETE FROM roles WHERE id = :id", ["id" => $this->id]);
        } catch (\PDOException $Exception) {
            return false;
        }
    }

    static function destroy($id): bool
    {
        try {
            return DB::execute("DELETE FROM roles WHERE id = :id", ["id" => $id]);
        } catch (\PDOException $Exception) {
            return false;
        }
    }
}
