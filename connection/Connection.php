<?
class Connection
{
    private $con;

    public function __construct()
    {
        $this->con = new mysqli("localhost", "root", "", "jbsm") or die("Sem conexao");
        $this->con->set_charset('latin1');
        $this->con->autocommit(true);
    }

    public function getInstance()
    {
        return $this->con;
    }
}
?>