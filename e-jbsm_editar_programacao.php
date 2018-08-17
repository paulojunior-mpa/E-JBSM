<?
$permissao = array("usuario", "administrador", "orientador", "bolsista");
include 'helpers/permitir.php';
$id = "";
if (isset($_POST["id"])) {
    $id = $_POST["id"];
}
$sql = "select * from ejbsm_programacao where id = '$id'";
$result = $link->query($sql) or die(mysql_error());
$r = mysqli_fetch_object($result);
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Editar programação</h3>

        <form action="controller/Controller.php" method="post">
            <table class="table">
                <tr>
                    <td>
                        Data
                        <input type="date" class="form-control" value="<?= $r->data ?>"
                               name="programacao_data" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Como você se sentiu nesta semana?
                        <select name="programacao_status" required class="form-control">
                            <option value="Muito bem">Muito bem</option>
                            <option value="Bem">Bem</option>
                            <option value="Normal">Normal</option>
                            <option value="Chateado(a)">Chateado(a)</option>
                            <option value="Muito chateado(a)">Muito chateado(a)</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Houve algum fato significativo na semana que passou?
            <textarea class="form-control" name="programacao_fato" required=""
                      placeholder="Houve algum fato extremamente significativo na semana que passou?"><? echo "$r->fato_significativo"; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Cite pontos positivos (produtivos) na semana que passou.
            <textarea class="form-control" name="programacao_pontos_produtivos" required=""
                      placeholder="Cite pontos positivos (produtivos) na semana que passou."><? echo "$r->produtivos"; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Cite pontos negativos (improdutivos) na semana que passou.
            <textarea class="form-control" name="programacao_pontos_inprodutivos" required=""
                      placeholder="Cite pontos negativos (improdutivos) na semana que passou."><? echo $r->improdutivos; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Você teria alguma sugestão para melhorar rendimento nas atividades executadas?
            <textarea class="form-control" name="programacao_sugestao" required=""
                      placeholder="Você teria alguma sugestão para melhorar rendimento nas atividades executadas?"><? echo $r->sugestao; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Algum item ou material se fez necessário para um melhor aproveitamento na execução das
                        atividades?
            <textarea class="form-control" name="programacao_material" required=""
                      placeholder="Algum item ou material se fez necessário para um melhor aproveitamento na execução das atividades?"><? echo "$r->material_necessario"; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Atividade prioritária para a próxima semana
            <textarea class="form-control" placeholder="Atividade prioritária para a próxima semana"
                      name="programacao_prioritaria" required=""><? echo $r->prioridades; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Segunda
                        <textarea class="form-control" name="programacao_segunda"
                                  required=""><? echo $r->segunda; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Terça
                        <textarea class="form-control" name="programacao_terca"
                                  required=""><? echo $r->terca; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Quarta
                        <textarea class="form-control" name="programacao_quarta"
                                  required=""><? echo $r->quarta; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Quinta
                        <textarea class="form-control" name="programacao_quinta"
                                  required=""><? echo $r->quinta; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Sexta
                        <textarea class="form-control" name="programacao_sexta"
                                  required=""><? echo $r->sexta; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?= $r->id ?>">
                        <input type="hidden" name="opcao" id="opcao" value="<?=Constantes::EDITAR_PROGRAMACAO?>">
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