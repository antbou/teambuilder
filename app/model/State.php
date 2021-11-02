<?php

namespace Teambuilder\model;

use Teambuilder\model\DB;
use Teambuilder\model\Model;

class State extends Model
{
    public $id;
    public $slug;
    public $name;

    /**
     * create object, but no db record
     *
     * @param array $fields
     * @return Role
     */
    static function make(array $fields): State
    {
        $state = new State();

        $state->id = (isset($fields['id'])) ? $fields['id'] : null;
        $state->slug = $fields["slug"];
        $state->name = $fields["name"];

        return $state;
    }

    /**
     * create db record from object
     *
     * @return boolean
     */
    public function create(): bool
    {
        try {
            return DB::insert("INSERT INTO states(slug,name) VALUES (:slug, :name)", ["slug" => $this->slug, "name" => $this->name]);
        } catch (\PDOException $Exception) {
            return false;
        }
    }

    /**
     * Find a state by params
     *
     * @param array $params
     * @return State|null
     */
    static function find(array $params): ?State
    {
        $parm = array_key_first($params);
        $res = DB::selectOne("SELECT * FROM states where $parm  = :$parm ", [$parm => $params[array_key_first($params)]]);
        return ($res) ? self::make($res) : null;
    }

    /**
     *  return all states
     *
     * @return array
     */
    static function all(): array
    {
        $res = [];

        // Create an array of objects
        foreach (DB::selectMany("SELECT * FROM states", []) as $state) {
            $res[] = self::make($state);
        }

        return $res;
    }

    public function save(): bool
    {
        try {
            return DB::execute("UPDATE states set name = :name, slug = :slug WHERE id = :id", ["slug" => $this->slug, "name" => $this->name, "id" => $this->id]);
        } catch (\PDOException $Exception) {
            return false;
        }
    }

    public function delete(): bool
    {
        try {
            return DB::execute("DELETE FROM states WHERE id = :id", ["id" => $this->id]);
        } catch (\PDOException $Exception) {
            return false;
        }
    }

    static function destroy($id): bool
    {
        try {
            return DB::execute("DELETE FROM states WHERE id = :id", ["id" => $id]);
        } catch (\PDOException $Exception) {
            return false;
        }
    }
}
