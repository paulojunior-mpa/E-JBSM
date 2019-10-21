<?php
class Connection
{
    private static $con;

    public function __construct()
    {
        self::$con = new mysqli("localhost", "ejbsm", "MH1d5He5tC0AvbB", "ejbsm") or die("Sem conexao");
        self::$con->set_charset('latin1');
        self::$con->autocommit(true);
    }

    public static function getInstance()
    {
        return self::$con;
    }
}
?>