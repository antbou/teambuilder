# TeamBuilder
Realize for PRW1
## Requirements

| Tools                                         | Version |
|-----------------------------------------------|---------|
| [Composer](https://getcomposer.org/download/) | 2.1.6   |
| [Php](https://www.php.net/downloads.php)      | 8.0.9   |

## Install

```bash
git clone https://github.com/antbou/teambuilder.git
composer install
```

## Usage

The different local variables are found in the `.env.php` file which must be located at the root of the project.
The sample file is named `.env-exemple.php`

### Autoconnect and Database configuration

The auto-connection is defined with a constant "USER_ID" followed by the ID of the desired user.
The user ID can be found in the database.

```
<?php
define("DBHOST", "TO_CHANGE");
define("DBNAME", "TO_CHANGE");
define("DBUSERNAME", "TO_CHANGE");
define("DBPASSWORD", "TO_CHANGE");

define("USER_ID", 1);
```
## Load database
The script will load the following sql file `db/teambuilder.sql`.
```bash
php loadMe.php
```
## Test
The script will automatically reload the database (loadMe.php) before running the tests.
```bash
composer test
```