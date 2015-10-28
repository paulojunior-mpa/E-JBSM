<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 25/10/2015
 * Time: 11:07
 */
if(isset($_GET['search'])){
    if(!empty($_GET['search'])){

        $search = $_GET['search'];

        $array_filters = array('especie', 'genero', 'familia', 'nome_popular', 'descricao', 'origem');

        if(isset($_GET['filter'])){
            if(!empty($_GET['filter'])){
                $array_filters = json_decode($_GET['filter']);
            }
        }
        $sql_final = "select * from ejbsm_planta where 1 = 1 ";

        foreach ($array_filters as $filter) {
            $sql_final.= "AND $filter like '%$search%' ";
        }

        echo $sql_final;
    }
}