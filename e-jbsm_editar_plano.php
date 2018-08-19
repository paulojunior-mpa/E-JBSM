<?
isUserInRole(array("administrador", "orientador", "bolsista"));
;
if (isset($_POST["id"])) {
    $id = $_POST["id"];
}
$sql = "select * from ejbsm_plano where id = $id";
$qr = $link->query($sql);
$r = mysqli_fetch_object($qr);
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Editar plano <?= $r->nome ?></h3>

        <form action="controller/SystemController.php" method="post">
            <table class="table">
                <tr>
                    <td>Nome
                        <input type="text" class="form-control" placeholder="Nome do Plano" name="nome"
                               value="<?= $r->nome ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Público alvo
                        <input type="text" class="form-control" placeholder="Público alvo" name="publicoAlvo"
                               value="<?= $r->publico_alvo ?>"
                               required>
                    </td>
                </tr>
                <tr>
                    <td>Guia
                        <select name="nomeGuia" class="form-control" required>
                            <?
                            $sql = "select * from ejbsm_usuario, ejbsm_integrante WHERE ejbsm_usuario.login = ejbsm_integrante.login and monitor = 'sim' AND status != 'Inativo'";
                            $result = $link->query($sql);
                            while ($row = mysqli_fetch_object($result)) {
                                $Pnome = explode(" ", $row->nome);
                                ?>
                                <option value="<?= $Pnome[0] ?>"><? echo "$row->login / ";
                                    echo "$Pnome[0]"; ?>
                                </option>
                            <? } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Objetivo
                        <textarea class="form-control" cols="80" rows="3" placeholder="Objetivo" name="objetivo"
                                  required><?= $r->objetivo ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Assuntos
                        <textarea class="form-control" cols="80" rows="3" placeholder="Assuntos para abordar"
                                  name="assunto"
                                  required><?= $r->assunto ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Estratégias cognitivas
                        <textarea class="form-control" cols="80" rows="3" placeholder="Estratégias cognitivas"
                                  name="estrategia"
                                  required><?= $r->estrategia ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Recursos
                        <textarea class="form-control" cols="80" rows="3" placeholder="Recursos extras"
                                  name="recursos"
                                  required><?= $r->recursos ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Locais para visitar
                        <textarea class="form-control" cols="80" rows="3" placeholder="Locais a serem visitados"
                                  name="locais"
                                  required><?= $r->locais ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Relevancia de locais
                        <textarea class="form-control" cols="80" rows="3" placeholder="Relevância de cada local"
                                  name="relevancia"
                                  required><?= $r->relevancia ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Instrumentos de coleta de dados
                        <textarea class="form-control" cols="80" rows="3"
                                  placeholder="Instrumento de coleta de dados"
                                  name="instrumento" required><?= $r->instrumento ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?= $r->id ?>">
                        <input type="hidden" name="opcao" id="opcao" value="<?=Constantes::EDITAR_PLANO?>">
                        <button class="btn btn-success" type="submit">
                            <span class="glyphicon glyphicon-save"></span>
                            Salvar edição
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>