<?php
/**
 * Created by PhpStorm.
 * User: willian.manucello
 * Date: 17/08/2018
 * Time: 17:16
 */

class eJBSM
{
    /**
     * eJBSM constructor.
     */
    public function __construct()
    {
        $this->import();

        $con = new Connection();
        $link = $con->getInstance();

        $page = getParameter('ejbsm_uri');
        if (!empty($page)) {
            $page = explode('/', $page);
            $page = explode('.php', end($page))[0];
            include $page . '.php';
        } else
            include 'index.php';
    }

    private function import()
    {
        include 'constantes/Constantes.php';
        include 'connection/Connection.php';
    }
}

function getParameter($key)
{
    if (isset($_REQUEST[$key]))
        return htmlspecialchars($_REQUEST[$key], ENT_QUOTES, 'UTF-8');
    return '';
}

new eJBSM();

exit;