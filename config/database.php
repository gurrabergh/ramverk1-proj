<?php
/**
 * Config file for Database.
 *
 * Example for MySQL.
 *  "dsn" => "mysql:host=localhost;dbname=test;",
 *  "username" => "test",
 *  "password" => "test",
 *  "driver_options"  => [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
 *
 * Example for SQLite.
 *  "dsn" => "sqlite::memory:",
 *  "dsn" => "sqlite:$path",
 *
 */
$name = $_SESSION["test"] ?? "";

if ($name === "test") {
    return [
        "dsn" => "sqlite:" . ANAX_INSTALL_PATH . "/db/test_db.sqlite",
        "username"         => null,
        "password"         => null,
        "driver_options"   => [
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
        ],
        "fetch_mode"       => \PDO::FETCH_OBJ,
        "table_prefix"     => null,
        "session_key"      => "Anax\Database",
        "emulate_prepares" => false,
    
        // True to be very verbose during development
        "verbose"         => null,
    
        // True to be verbose on connection failed
        "debug_connect"   => true,
    ];
}

if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] === "www.student.bth.se") {
    $psw = file_get_contents(ANAX_INSTALL_PATH . "/data/DB_PSW");
    return [
        "dsn"             => "mysql:host=blu-ray.student.bth.se;dbname=gubg19;",
        "username"        => "gubg19",
        "password"        =>  "$psw",
        "driver_options"  => [
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
        ],
        "fetch_mode"      => \PDO::FETCH_OBJ,
        "table_prefix"    => null,
        "session_key"     => "Anax\Database",
        "emulate_prepares" => false,

        // True to be very verbose during development
        "verbose"         => false,

        // True to be verbose on connection failed
        "debug_connect"   => true,
    ];
}

return [
    "dsn" => "mysql:host=localhost;dbname=ramverk1;",
    "username"         => "user",
    "password"         => "pass",
    "driver_options"   => [
        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
    ],
    "fetch_mode"       => \PDO::FETCH_OBJ,
    "table_prefix"     => null,
    "session_key"      => "Anax\Database",
    "emulate_prepares" => false,

    // True to be very verbose during development
    "verbose"         => null,

    // True to be verbose on connection failed
    "debug_connect"   => true,
];
