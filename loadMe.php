<?php

/**
 * This script automatically loads the database
 */

use Teambuilder\core\model\DB;

require_once('./app/core/model/DB.php');

const SCHEMA =  './db/teambuilder.sql';

$query = file_get_contents(SCHEMA);

try {
    DB::execute($query, []);
    print "\e[0;30;42mScript successfully executed \e[0m\n" . PHP_EOL;
    exit(0);
} catch (\Throwable $ex) {
    print "\e[0;30;41mAn error has occurred :\e[0m\n" . PHP_EOL;
    print $ex->getMessage();
    exit(1);
}
