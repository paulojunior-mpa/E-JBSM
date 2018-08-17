<?
$permissao = array("usuario", "administrador", "orientador", "bolsista");
include 'helpers/permitir.php';
?>
<div class="panel panel-default">
    <div class="panel-body">
        <style>
            .alert {
                width: 200px;
                height: 200px;
                margin-left: 10px;
                float: left;
                border-radius: 0px;
                font-variant: small-caps;
                font-size: 20px;
                text-align: center;
                color: #080808;
            }
        </style>
        <?
        $title = array("Cadastrar visita", "Listar visitas", "Seu perfil", "Lixeira", "Sobre");
        $image = array("cadastro", "lista", "usuario", "lixeira", "identificar");
        $link = array("e-jbsm_cadastro_visita", "e-jbsm_lista_visitas", "e-jbsm_perfil", "e-jbsm_lixeira", "e-jbsm_sobre");
        $j = 0;
        foreach ($title as $titulo) {
            echo "<a href='$link[$j].php'>
                <div class='alert alert-success' role='alert'>
                    <img src='arquivos_imagem_sistema/$image[$j].png'><br>
                    <b>$title[$j]</b>
                </div>
            </a>";
            $j++;
        }
        if($user_permissao=="administrador"){
            $title = array("E-mail's", "Cadastrados");
            $image = array("email", "cadastrados");
            $link = array("e-jbsm_email", "e-jbsm_lista_cadastro");
            $j = 0;
            foreach ($title as $titulo) {
                echo "<a href='$link[$j].php'>
                <div class='alert alert-success' role='alert'>
                    <img src='arquivos_imagem_sistema/$image[$j].png'><br>
                    <b>$title[$j]</b>
                </div>
            </a>";
                $j++;
            }
        }
        ?>
    </div>
</div>