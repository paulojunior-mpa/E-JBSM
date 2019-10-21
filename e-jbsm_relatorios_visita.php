<?php
isUserInRole(array("usuario", "administrador", "orientador", "bolsista"));
;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <script>
            function setText() {
                var x = document.getElementById('select1')
                value = x.options[x.selectedIndex].value
                if (value == 'Por período') {
                    campo2.innerHTML = "";
                    campo1.innerHTML = "" +
                    "De<input class='form-control' name='inicio' type='date' required=''>" +
                    "Até<input class='form-control' name='fim' type='date' required=''>";
                    Button.innerHTML = "<br><button class='btn btn-success btn-block' type='submit' name='opcao' value='Relatorio de visitas'><span class='glyphicon glyphicon-search'></span> Pesquisar</button>"
                }
                else if (value == 'Por usuário') {
                    campo2.innerHTML = "";
                    campo1.innerHTML = "Login do usuário<input class='form-control' type='text' name='login' placeholder='digite o login' required=''>";
                    Button.innerHTML = "<button class='btn btn-success btn-block' type='submit' name='opcao' value='Relatorio de visitas'><span class='glyphicon glyphicon-search'></span> Pesquisar</button>"
                }
                else if (value == 'Por usuário em um período') {
                    campo1.innerHTML = "Login do usuário<input class='form-control' type='text' name='login' placeholder='digite o login' required=''>";
                    campo2.innerHTML = "De<input class='form-control' name='inicio' type='date' required=''> Até<input class='form-control' name='fim' type='date' required=''>";
                    Button.innerHTML = "<button class='btn btn-success btn-block' type='submit' name='opcao' value='Relatorio de visitas'><span class='glyphicon glyphicon-search'></span> Pesquisar</button>"
                }
                else {
                    campo1.innerHTML = "";
                    campo2.innerHTML = "";
                    Button.innerHTML = "";
                }
            }
        </script>
        <h3>Relatórios de visitas</h3>

        <div class="alert alert-info" role="alert">
            Aqui você pode gerar um relatório que inclui nº total de visitas com nº de visitantes, podendo selecionar
            entre datas específicas ou apenas cadastros de um usuário.
        </div>
        <form action="e-jbsm_relatorios_visita.php" method="post">
            <table class="table" style="width: auto">
                <tr>
                    <td>Número de visitantes
                        <select class="form-control" onChange='setText()' id='select1'>
                            <option>Selecione uma opção.</option>
                            <option>Por período</option>
                            <option>Por usuário</option>
                            <option>Por usuário em um período</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td id="campo1">
                    </td>
                    <td id="campo2">
                    </td>
                </tr>
                <tr>
                    <td id="Button">

                    </td>
                </tr>
            </table>
        </form>
        <?php
        $sql = "SELECT SUM(visitantes) as soma from ejbsm_visita where status = 'Confirmada'";
        $sql2 = "select id, login, data, hora, instituicao, visitantes from ejbsm_visita where status = 'Confirmada' order by id desc";
        if (isset($_POST["login"])) {
            $login = $_POST["login"];
            if (isset($_POST["inicio"]) and isset($_POST["fim"])) {
                $inicio = $_POST["inicio"];
                $fim = $_POST["fim"];
                $sql = "SELECT SUM(visitantes) as soma from ejbsm_visita where data >= '$inicio' and data <= '$fim' and login = '$login' and  status = 'Confirmada'";
                $sql2 = "select id, login, data, hora, instituicao, visitantes from ejbsm_visita where data >= '$inicio' and data <= '$fim' and login = '$login' and  status = 'Confirmada' order by id desc";
            } else {
                $sql = "SELECT SUM(visitantes) as soma from ejbsm_visita where login = '$login' and  status = 'Confirmada'";
                $sql2 = "select id, login, data, hora, instituicao, visitantes from ejbsm_visita where login = '$login' and  status = 'Confirmada' order by id desc";
            }
        } else if (isset($_POST["inicio"]) and isset($_POST["fim"])) {
            $inicio = $_POST["inicio"];
            $fim = $_POST["fim"];
            $sql = "SELECT SUM(visitantes) as soma from ejbsm_visita where data >= '$inicio' and data <= '$fim' and  status = 'Confirmada'";
            $sql2 = "select id, login, data, hora, instituicao, visitantes from ejbsm_visita where data >= '$inicio' and data <= '$fim' and status= 'Confirmada' order by id desc";
        }
        //Pega soma de visitantes
        $result = $link->query($sql) or die(mysqli_error($link));
        $soma = mysqli_fetch_object($result) or die(mysqli_error($link));

        $result = $link->query($sql2) or die(mysqli_error($link));
        $numero = mysqli_num_rows($result);
        echo "<h4>Nº de visitas: $numero<br> Nº de visitantes : $soma->soma</h4>";
        ?>
        <table class=" table table-hover">
            <tr style="font-weight: bold">
                <td>ID</td>
                <td>Instituição</td>
                <td>Data</td>
                <td>Hora</td>
                <td>Nº de visitantes</td>
                <td>Login</td>
            </tr>
            <?while ($visita = mysqli_fetch_object($result)) {?>
                <tr>
                    <td><?php echo $visita->id?></td>
                    <td><?php echo $visita->instituicao?></td>
                    <td><?php echo $visita->data?></td>
                    <td><?php echo $visita->hora?></td>
                    <td><?php echo $visita->visitantes?></td>
                    <td><?php echo $visita->login?></td>
                </tr>
            <?php }?>
        </table>
    </div>
</div>