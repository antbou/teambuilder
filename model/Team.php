<?php

require_once('DB.php');

class Team
{
    public $id;
    public $name;
    public $state_id;

    /**
     * sauvegarde l'objet en bdd
     *
     * @return void
     */
    public function create()
    {
        $this->id = DB::insert("INSERT INTO teams(name,state_id) VALUES (:name, :state_id)", ['name' => $this->name, 'state_id' => $this->state_id]);
    }

    /**
     * Crée un objet Team
     *
     * @param integer $id
     * @param string $name
     * @param integer $state_id
     * @return Team|null
     */
    public static function make(int $id = null, string $name, int $state_id): Team
    {
        $team = new Team();
        $team->id = $id;
        $team->name = $name;
        $team->state_id = $state_id;

        return $team;
    }

    public static function find(int $id): ?Team
    {
        $res = DB::selectOne("SELECT * FROM teams where id = :id", ['id' => $id]);

        if (!isset($res[0])) {
            return null;
        }

        $res = $res[0];

        return self::make($res['id'], $res['name'], $res['state_id']);
    }

    public static function all(): array
    {
        return [];
    }

    public function save(): bool
    {
        return true;
    }

    public function delete(): bool
    {
        return true;
    }

    public static function destroy(int $id): bool
    {
        return true;
    }
}
