<?
$permissao = array("bolsista");
include 'Func/permitir.php';
?>
<ul class="nav nav-tabs" role="tablist" id="cadastro_programacao" xmlns="http://www.w3.org/1999/html">
    <li role="presentation" class="active"><a href="">Cadastro de programação</a></li>
    <li role="presentation"><a href="e-jbsm_lista_programacao.php">Lista de programações</a></li>
</ul>
<?
if (isset($_GET["info"]) and $_GET["info"] == "cadastrada") {
    echo '<div class="alert alert-success" role="alert">Programação cadastrada!</div>';
}?>
<form action="Servlet/Controller.php" method="post">
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Cadastro de programação</h3>
            <table class="table">
                <tr>
                    <td>
                        Data
                        <input type="date" class="form-control"
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
                        Houve algum fato extremamente significativo na semana que passou?
            <textarea class="form-control" name="programacao_fato" required=""
                      placeholder="Houve algum fato extremamente significativo na semana que passou?"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Cite pontos positivos (produtivos) na semana que passou.
            <textarea class="form-control" name="programacao_pontos_produtivos" required=""
                      placeholder="Cite pontos positivos (produtivos) na semana que passou."></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Cite pontos negativos (improdutivos) na semana que passou.
            <textarea class="form-control" name="programacao_pontos_inprodutivos" required=""
                      placeholder="Cite pontos negativos (improdutivos) na semana que passou."></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Você teria alguma sugestão para melhorar rendimento nas atividades executadas?
            <textarea class="form-control" name="programacao_sugestao" required=""
                      placeholder="Você teria alguma sugestão para melhorar rendimento nas atividades executadas?"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Algum item ou material se fez necessário para um melhor aproveitamento na execução das
                        atividades?
            <textarea class="form-control" name="programacao_material" required=""
                      placeholder="Algum item ou material se fez necessário para um melhor aproveitamento na execução das atividades?"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Atividade prioritária para a próxima semana
            <textarea class="form-control" placeholder="Atividade prioritária para a próxima semana"
                      name="programacao_prioritaria" required=""></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Segunda
                        <textarea class="form-control" name="programacao_segunda"
                                  required=""></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Terça
                        <textarea class="form-control" name="programacao_terca"
                                  required=""></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Quarta
                        <textarea class="form-control" name="programacao_quarta"
                                  required=""></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Quinta
                        <textarea class="form-control" name="programacao_quinta"
                                  required=""></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Sexta
                        <textarea class="form-control" name="programacao_sexta"
                                  required=""></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button class="btn btn-success" type="submit" name="opcao"
                                value="Cadastrar Programação">Cadastrar</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</form>