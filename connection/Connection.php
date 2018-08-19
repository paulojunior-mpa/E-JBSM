<?
class Connection
{
    private static $con;

    public function __construct()
    {
        self::$con = new mysqli("localhost", "root", "", "jbsm") or die("Sem conexao");
        self::$con->set_charset('latin1');
        self::$con->autocommit(true);
    }

    public static function getInstance()
    {
        return self::$con;
    }
}
?>