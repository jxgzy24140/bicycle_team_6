<?php
class Connector
{
    static $hostname   = "localhost";
    static $username = "root";
    static $password = "";
    static $database = "rent_bicycle";

    public static function Connect()
    {
        return mysqli_connect(
            Connector::$hostname, 
            Connector::$username, 
            Connector::$password, 
            Connector::$database
        );
    }
}
