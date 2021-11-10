<?php

namespace Teambuilder\model;

use Teambuilder\model\DB;
use Teambuilder\model\Model;

class State extends Model
{
    public $id;
    public $slug;
    public $name;

    protected string $table;

    public function __construct()
    {
        $this->table = self::getShortName(self::class);
    }

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
}
