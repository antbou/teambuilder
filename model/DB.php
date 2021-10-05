<?php

namespace Teambuilder\model;

use PDO;

class DB
{

    public static function getPdo(): PDO
    {
        require_once('.env.php');
        return new PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';charset=utf8', DBUSERNAME, DBPASSWORD, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function selectMany(string $query, array $params): array
    {
        $sth = self::getPdo()->prepare($query);
        $sth->execute($params);

        $result = $sth->fetchAll();
        return $result;
    }

    public static function selectOne(string $query, array $params): array
    {
        $sth = self::getPdo()->prepare($query);
        $sth->execute($params);

        $result = $sth->fetchAll();
        return $result;
    }

    public static function insert(string $query, array $params): int
    {
        $db = self::getPdo();
        $sth = $db->prepare($query);
        $sth->execute($params);

        $result = $db->lastInsertId();
        return $result;
    }

    public static function execute(string $query, array $params): bool
    {
        $db = self::getPdo();
        $sth = $db->prepare($query);
        $sth->execute($params);

        return $sth->execute($params);
    }
}
