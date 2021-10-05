<?php

namespace Teambuilder\model;

use Teambuilder\model\DB;


class Team
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
        if (!isset($res[0])) {
            return null;
        }

        $res = $res[0];
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

        foreach (DB::selectMany("SELECT * FROM teams", []) as $index) {
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
}
