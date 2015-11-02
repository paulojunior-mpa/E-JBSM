<?php
if (isset($_GET["operation"])) {
    if ($_GET["operation"] != "" AND $_GET["operation"] != null) {
        $operation = htmlspecialchars($_GET["operation"]);

        require_once 'webservice/connection.php';

        $connection = new Connection();

        require_once 'webservice/util.php';

        $link = $connection->link();

        switch ($operation) {
            case "plant":
                require_once 'webservice/views/printPlant.php';
                include 'webservice/plant.php';
                break;

            case "login":
                include 'webservice/login.php';
                break;

            case "plants":
                include 'webservice/plants.php';
                break;

            case 'search':
                include 'webservice/search.php';
                break;

            case 'img':
                include 'webservice/img.php';
                break;
        }
    } else {
        echo "OPERACAO null.";
    }
} else {
    echo "OPERACAO no.";
}
?>