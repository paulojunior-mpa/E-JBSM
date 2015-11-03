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
                $filter = $_GET['filter'];
                $array_filters = array("$filter");
            }
        }
        $sql_final = "select * from ejbsm_planta where 1 = 1 ";

        foreach ($array_filters as $filter) {
            $sql_final.= "AND $filter like '%$search%' ";
        }

        $sql_final.=" limit 5";

        $result = $link->query($sql_final) or die(mysqli_error($link));

        $array_plants = array();

        if(mysqli_num_rows($result)>0) {
            while ($plant = mysqli_fetch_object($result)) {
                unset($plant->img);
                array_push($array_plants, $plant);
            }
        }else{
            exit;
        }

        $json = json_encode($array_plants);

        echo $json;
    }
}