<?
$permissao = array("usuario", "administrador", "orientador", "bolsista");
include 'helpers/permitir.php';
?>
<h3>Mapa de navegação do sistema por nível de usuário</h3>
<div class="panel panel-default">
    <div class="alert-info">
        <table width="100%">
            <tr>
                <td>Legenda</td>
                <td><div style="width: 20px; height: 20px; background: #50873a"></div> Usuario</td>
                <td><div style="width: 20px; height: 20px; background: #eb9316"></div> Bolsista</td>
                <td><div style="width: 20px; height: 20px; background: #0366f0"></div> Orientador</td>
                <td><div style="width: 20px; height: 20px; background: #d43f3a"></div> Administrador</td>
            </tr>
        </table>
    </div>
    <div class="panel-body">
        <img src="arquivos_imagem_sistema/sistema_mapa.png" width="100%">
    </div>
</div>