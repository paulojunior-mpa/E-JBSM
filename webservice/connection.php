<?php

/**
 * Created by PhpStorm.
 * User: willian.manucello
 * Date: 10/27/2015
 * Time: 9:06 AM
 */
class Connection
{
    function link(){
        return new mysqli("localhost", "jbsm", "santo1981", "JBSM") or die("Sem conexao");
    }
}