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
    ID<input type="text" name="id" value="20"><br>
    USUARIO<input type="text" name="usuario" value="willian"><br>
    LAT<input type="text" name="lat" value="-29.6815435"><br>
    LONG<input type="text" name="long" value="-53.8074623"><br>
    <input type="submit" name="operacao" value="id">
</form>
<form action="webservice.php" method="get" target="_blank">
    <hr>
    LOGIN<input type="text" name="login" value="willian"><br>
    USUARIO<input type="text" name="senha" value="dc032056e839884d74910e1c442a7ee8f3434a38"><br>
    <input type="submit" name="operacao" value="login">
</form>
<form action="webservice.php" method="get" target="_blank">
    <hr>
    USUARIO<input type="text" name="usuario" value="willian"><br>
    <input type="submit" name="operacao" value="plantas">
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