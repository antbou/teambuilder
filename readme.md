# TeamBuilder

## Local variable

The different local variables are found in the .env.php file which must be located at the root of the project.

### Autoconnect and Database configuration

The auto-connection is defined with a constant "USER_ID" followed by the ID of the desired user.
The user ID can be found in the database.
Database

```
<?php
define("USER_ID", 1);
define("DBHOST", "TO_CHANGE");
define("DBNAME", "TO_CHANGE");
define("DBUSERNAME", "TO_CHANGE");
define("DBPASSWORD", "TO_CHANGE");
```

## Dependencies

In the project, we only use composer :

`composer i`
