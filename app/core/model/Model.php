<?php

namespace Teambuilder\core\model;

use Teambuilder\core\model\DB;
use Teambuilder\core\traits\ClassToTable;
use Teambuilder\core\traits\GetChildrenProperties;

require('./.env.php');

abstract class Model
{
    use ClassToTable, GetChildrenProperties;

    public $id;
    private string $table;
    private static string $classname;

    public function __construct()
    {
        self::$classname = static::class;
        $this->table = self::getShortName(static::class);
    }


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
    public static function destroy(int $id): bool
    {
        try {
            DB::execute('DELETE FROM ' . self::getShortName(self::$classname) . ' WHERE id = :id', ['id' => $id]);
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

    /**
     * search an entry by its id
     *
     * @param integer $id
     * @param string|null $classname
     * @param string|null $order
     * @return object|null
     */
    public static function find(int $id, string $classname = null, string $order = null): ?object
    {
        $classname = (is_null($classname)) ? static::class : $classname;
        $query = 'select * from ' . self::getShortName($classname) . ' where id = :id' . ((is_null($order)) ? '' : ' ORDER BY ' . $order);
        return DB::selectOne($query, ['id' => $id], $classname);
    }

    /**
     * search all entries matching the object 
     *
     * @param string|null $classname
     * @param string|null $order
     * @return array
     */
    public static function all(string $classname = null, string $order = null): array
    {
        $classname = (is_null($classname)) ? static::class : $classname;
        $query = 'select * from ' . self::getShortName($classname) . ((is_null($order)) ? '' : ' ORDER BY ' . $order);
        return DB::selectMany($query, [], $classname);
    }

    /**
     * Get all according to criteria and value
     *
     * @param string $attribute
     * @param string $value
     * @param string|null $classname
     * @param string|null $order
     * @return array
     */
    public static function where(string $attribute, string $value, string $classname = null, string $order = null): array
    {
        $classname = (is_null($classname)) ? static::class : $classname;
        $query = 'select * from ' . self::getShortName($classname) . ' WHERE ' . $attribute . ' = :' . $attribute . ((is_null($order)) ? '' : ' ORDER BY ' . $order);
        return DB::selectMany($query, [$attribute => $value], $classname);
    }
}
