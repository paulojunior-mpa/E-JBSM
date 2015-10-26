<?
include 'Service/Conexao.php';
include 'e-jbsm_cabecalho.php';
?>
<!--
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script src="js/jquery.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="js/mapa_sobre.js"></script>

<button class="btn btn-info" onclick="getLocation()">Quais minhas coordenadas?</button>
<textarea class="form-control" placeholder="Use coordenadas ou um endereço, por ex. Escola de Fulano - Avenida Ciclano Silva de Almeida, Rio Grande do Sul, 97760-000, Brasil" id="txtEnderecoPartida" value="" name="txtEnderecoPartida"></textarea>
<div id="mapa" style="visibility: hidden"></div>
-->
<form action="webservice.php" method="get" target="_blank">
    <hr>
    <script src="js/mapa_sobre.js"></script>
    Planta ID<input type="text" name="id" value="1"><br>
    Login<input type="text" name="login" value="willian"><br>
    Imei<input type="text" name="imei" value="123456" required>
    LAT<input type="text" name="lat" value="-29.6815435"><br>
    LONG<input type="text" name="long" value="-53.8074623"><br>
    <input type="submit" name="operation" value="plant">
</form>
<form action="webservice.php" method="get" target="_blank">
    <hr>
    LOGIN<input type="text" name="login" value="willian"><br>
    USUARIO<input type="text" name="senha" value="f7huz3a6"><br>
    <input type="submit" name="operation" value="login">
</form>
<form action="webservice.php" method="get" target="_blank">
    <hr>
    Login<input type="text" name="user" value="willian"><br>
    Imei<input type="text" name="imei" value="123456" required>
    <input type="submit" name="operation" value="plants">
</form>

<form action="webservice.php" method="get" target="_blank">
    <hr>
    Nome<input type="text" name="nome" value="unha-de-gato"><br>
    Genero<input type="text" name="genero" value="gênero"><br>
    Familia<input type="text" name="familia" value="FABACEAE"><br>
    Florescimento inicio<input type="date" name="florescimento_inicio" value=""><br>
    Florescimento fim<input type="date" name="florescimento_fim" value=""><br>
    <input type="submit" name="operacao" value="filtro">
</form>