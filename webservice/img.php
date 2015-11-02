<?php
/**
 * Created by PhpStorm.
 * User: Willi
 * Date: 02/11/2015
 * Time: 20:08
 */
//ID foi setado?
if (isset($_GET['id'])) {
    //ID naõ está nulo nem vazio?
    if (!empty($_GET["id"])) {
        //  limpa ID da planta de possíveis comentários
        $plant_id = htmlspecialchars($_GET["id"]);

        $sql = "select * from ejbsm_planta WHERE id = $plant_id";
        $result =$link->query($sql);

        $plant = mysqli_fetch_object($result);

        if (!empty($plant->img)) {
            list($largura, $altura) = getimagesize("data:image/jpeg;base64," . base64_encode($plant->img));
            $max = 180;
            $x = ($altura * $max) / $largura;
            echo "<img src='data:image/jpeg;base64," . base64_encode($plant->img) . "' width='$max' height='$x'>";
        }
    }
}