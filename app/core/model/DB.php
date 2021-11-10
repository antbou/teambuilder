<?php

namespace Teambuilder\core\model;

use PDO;
use PDOException;

class DB
{

    private static $instance = null;

    /**
     * Returns a connection to the database
     * 
     * @return PDO
     */
    public static function getPdo(): PDO
    {
        try {
            if (self::$instance === null) {
                require_once('.env.php');
                self::$instance = new PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';charset=utf8', DBUSERNAME, DBPASSWORD);
            }
            return self::$instance;
        } catch (PDOException $e) { // in case of error for the debug
            echo 'Connection failure : ' . $e->getMessage();
            exit;
        }
    }

    public static function selectMany(string $query, array $params, string $className): array
    {
        $sth = self::getPdo()->prepare($query);
        $sth->execute($params);
        $sth->setFetchMode(PDO::FETCH_CLASS, $className);
        return $sth->fetchAll();
    }

    public static function selectOne(string $query, array $params, string $className): ?object
    {
        $sth = self::getPdo()->prepare($query);
        $sth->execute($params);
        $sth->setFetchMode(PDO::FETCH_CLASS, $className);
        $result = $sth->fetch();

        return ($result) ? $result : null;
    }

    public static function insert(string $query, array $params): int
    {
        $db = self::getPdo();
        $sth = $db->prepare($query);
        $sth->execute($params);

        return $db->lastInsertId();
    }

    public static function execute(string $query, array $params): bool
    {
        $db = self::getPdo();
        $sth = $db->prepare($query);

        return $sth->execute($params);
    }
}
