<?php
include 'e-jbsm_cabecalho.php';
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="panel-heading">
            <h3 class="panel-title">Informações gerais e contato</h3>
        </div>
        <div class="panel-body">
            <?php
            $sql = "select * from ejbsm_informacao WHERE id = 1";
            $result = $link->query($sql);
            $linha = mysqli_fetch_object($result);
            echo "<b style='color: green'>Unidade/Empresa: </b>" . $linha->nome . "<br>";
            echo "<b style='color: green'>Instituição: </b>" . $linha->instituicao . "<br>";
            echo "<b style='color: green'>Fone: </b>" . $linha->fone1 . "<br>";
            echo "<b style='color: green'>Fone alternativo: </b>" . $linha->fone2 . "<br>";
            echo "<b style='color: green'>E-mail: </b>" . $linha->email . "<br>";
            echo "<b style='color: green'>Endereco: </b>" . $linha->endereco . "<br>";
            echo "<b style='color: green'>Descrição: </b>" . $linha->descricao . "<br>";
            ?>
        </div>
        <?php /*
        <div class="panel-heading">
            <h3 class="panel-title"><div style='color: green'><b>Localização: </b><?php echo "Latitude " . $linha->latitude;
                    echo " Longitude " . $linha->longitude; ?></div></h3>
        </div>
        <div class="panel-body" id="local">
            <script src="https://maps.googleapis.com/maps/api/js"></script>
            <script src="resources/js/jquery.min.js"></script>
            <script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
            <script src="resources/js/mapa_sobre.js"></script>
            <legend>Gerar rota</legend>
            <button class="btn btn-info" onclick="getLocation()">Quais minhas coordenadas?</button>
            <form method="post" action="">
                <textarea class="form-control" placeholder="Use coordenadas ou um endereço, por ex. Escola de Fulano - Avenida Ciclano Silva de Almeida, Rio Grande do Sul, 97760-000, Brasil" id="txtEnderecoPartida" value="" name="txtEnderecoPartida"></textarea>
                    <span class="input-group-addon" id="basic-addon1">
                        <button type="submit" class="btn btn-success btn-block" id="btnEnviar" name="btnEnviar" value="Gerar rota">
                            Gerar rota
                        </button>
                    </span>
                <input type="hidden" value="<?php echo "$linha->latitude, $linha->longitude" ?>" class="form-control"
                       id="txtEnderecoChegada" name="txtEnderecoChegada"/>
            </form>
            <div id="mapa" style="height: 350px; width: 100%"></div>
            <script src="resources/js/jquery.min.js"></script>

            <!-- Maps API Javascript -->
            <script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

            <!-- Arquivo de inicialização do mapa -->
            <script src="resources/js/mapa_sobre.js"></script>
            <div class="panel-heading">
                <h3 class="panel-title">Sobre o sistema e-JBSM</h3>
            </div>
            <div class="panel-body" id="sistema">
                Sistema de gerência de visitações a jardins botânicos e atividades de bolsistas.<br>
                Desenvolvido pelo núcleo de informatização do Jardim Botânico da Universidade Federal de Santa Maria -
                RS.
            </div>
        </div>
        */?>
    </div>
</div>