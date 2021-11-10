<?php

namespace Teambuilder\model;

use Teambuilder\model\traits\Children;
use Teambuilder\model\traits\Table;

require('./.env.php');

abstract class Model
{
    use Children;
    use Table;

    public $id;
    protected string $table;


    /**
     * create db record from object
     *
     * @return boolean
     */
    public function create(): bool
    {

        $fields = [];
        $fieldsBind = [];
        foreach ($this->toArray() as $field => $value) {
            $fields[] = $field;
            $fieldsBind[] = ":$field";
        }

        $fields = implode(',', $fields);
        $fieldsBind = implode(',', $fieldsBind);
        $query = "INSERT INTO {$this->table} ($fields) VALUES ($fieldsBind)";

        try {
            $this->id = DB::insert($query, $this->toArray());
            return true;
        } catch (\PDOException $Exception) {
            return false;
        }
    }

    /**
     * Removes the object from the database
     *
     * @return boolean
     */
    public static function destroy(int $id, string $table): bool
    {
        try {
            DB::execute("DELETE FROM {$table} WHERE id = :id", ['id' => $id]);
            return true;
        } catch (\PDOException $Exception) {
            return false;
        }
    }

    /**
     * Removes the object from the database
     *
     * @return boolean
     */
    public function delete(): bool
    {
        return self::destroy($this->id, $this->table);
    }

    /**
     * update the object in the database
     *
     * @return boolean
     */
    public function save(): bool
    {
        $fields  = [];

        foreach ($this->toArray() as $field => $fieldsBind) {

            if ($field !== 'id') {
                $fields[] = "$field=:$field";
            }
        }

        $fields = implode(',', $fields);

        $query = "UPDATE {$this->table} SET $fields WHERE id=:id";

        try {
            return DB::execute($query, $this->toArray());
        } catch (\PDOException $Exception) {
            return false;
        }
    }
}
