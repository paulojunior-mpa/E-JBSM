<div id="map-canvas" style="height: 350px; width: 100%"></div>
<hr>
<script src="js/jquery.min.js"></script>
<!-- Maps API Javascript -->
<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<div id="map-canvas"></div>
<script>
    // This example creates a 2-pixel-wide red polyline showing
    // the path of William Kingsford Smith's first trans-Pacific flight between
    // Oakland, CA, and Brisbane, Australia.
    <?
            $sql = "select * from ejbsm_informacao WHERE id = 1";
            $result = $link->query($sql) or die(mysqli_error($link));
            $inst = mysqli_fetch_object($result);
    ?>
    var myLatlng = new google.maps.LatLng(<?=$inst->latitude?>, <?=$inst->longitude?>);
    function initialize() {
        var mapOptions = {
            zoom: 17,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.SATELLITE
        };

        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);

        var flightPlanCoordinates = [
            <?
            $sql = "select * from ejbsm_associa_planta WHERE id_trilha = $id_trilha_select";
            $result = $link->query($sql) or die(mysqli_error($link));
            while ($trilha = mysqli_fetch_object($result)) {
                $sql = "select * from ejbsm_planta WHERE id = $trilha->id_planta";
                $result2 = $link->query($sql) or die(mysqli_error($link));
                $planta = mysqli_fetch_object($result2) or die(mysqli_error($link));
                echo "new google.maps.LatLng($planta->latitude, $planta->longitude),";
            }
            ?>
        ];
        var flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            geodesic: true,
            strokeColor: 'orange',
            strokeOpacity: 1.0,
            strokeWeight: 2
        });

        var contentString = '<div id="content">' +
            '<div id="siteNotice">' +
            '</div>' +
            '<h1 id="firstHeading" class="firstHeading"><?=$inst->nome?></h1>' +
            '<div id="bodyContent">' +
            '<p><?=$inst->titulo?>.</p>' +
            '<p>Fone: <?=$inst->fone1?>. Adicional: <?=$inst->fone2?>. E-mail: <?=$inst->email?>.</p>' +
            '</div>' +
            '</div>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: '<?=$inst->titulo?>'
        });
        marker.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png');
        google.maps.event.addListener(marker, 'click', function () {
            infowindow.open(map, marker);
        });
        <?
            $sql = "select * from ejbsm_associa_planta WHERE id_trilha = $id_trilha_select";
            $result = $link->query($sql) or die(mysqli_error($link));
            $j=1;
            while ($trilha = mysqli_fetch_object($result)) {
                $sql = "select * from ejbsm_planta WHERE id = $trilha->id_planta";
                $result2 = $link->query($sql) or die(mysqli_error($link));
                $planta = mysqli_fetch_object($result2) or die(mysqli_error($link));
                ?>
        var contentString<?=$j?> = '<div id="content">' +
            '<div id="siteNotice">' +
            '</div>' +
            '<h1 id="firstHeading" class="firstHeading"><?=$planta->nome_popular?></h1>' +
            '<div id="bodyContent">' +
            '<p><?=$planta->especie?>.</p>' +
            '<p>Descrição: <?=$planta->descricao?>.' +
            '</div>' +
            '</div>';

        var infowindow<?=$j?> = new google.maps.InfoWindow({
            content: contentString<?=$j?>
        });
        var marker<?=$j?> = new google.maps.Marker({
            position: new google.maps.LatLng(<?=$planta->latitude?>, <?=$planta->longitude?>),
            map: map,
            title: '<?=$planta->nome_popular?>'
        });
        google.maps.event.addListener(marker<?=$j?>, 'click', function () {
            infowindow<?=$j?>.open(map, marker<?=$j?>);
        });
        <?
        $j++;
            }
        ?>

        flightPath.setMap(map);
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>