<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 25/10/2015
 * Time: 11:21
 */
class connection{
    function link(){
        return new mysqli("localhost", "jbsm", "santo1981", "JBSM");
    }
}