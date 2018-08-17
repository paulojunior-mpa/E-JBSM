<?
$permissao = array("administrador", "orientador", "bolsista");
include 'functions/permitir.php';

if (isset($_GET["info"]) and $_GET["info"] == "editado") {
    echo "<div class='alert alert-success' role='alert'>Dados do bolsista foram alterados!</div>";
}
function PegaHorarios($condicao, $login, $link)
{
    echo "<table style='text-align: center; text-align: center;'>
        <tr style='width: 100%'>
            <td></td>
            <td style='width: 18%'><font size='5' color='#556b2f'>Seg</font></td>
            <td style='width: 18%'><font size='5' color='#556b2f'>Ter</font></td>
            <td style='width: 18%'><font size='5' color='#556b2f'>Qua</font></td>
            <td style='width: 18%'><font size='5' color='#556b2f'>Qui</font></td>
            <td style='width: 18%'><font size='5' color='#556b2f'>Sex</font></td>
        </tr>";
    $semana = array("seg", "ter", "qua", "qui", "sex");
    $h = 8;
    $h2 = 9;
    for ($i = 0; $i < 8; $i++) {
        echo "<tr>";
        if ($h == 12) {
            $h++;
            $h2++;
        }
        echo "<td><font size='4' color='#556b2f'>$h:30-$h2:30</font></td>";
        for ($j = 0; $j < 5; $j++) {
            echo "<td style='width: 18%'><div style='border: 1px solid #556b2f; background-color: #66cdaa; margin-left: 3px; margin-bottom: 3px;'>";
            if ($condicao == 1)
                $sql = "select * from ejbsm_horario_bolsista where $semana[$j]$h$h2 = '1';";
            else
                $sql = "select * from ejbsm_horario_bolsista where $semana[$j]$h$h2 = '1' and login = '$login';";
            $result = $link->query($sql) or die (mysqli_error($link));
            while ($r = mysqli_fetch_object($result)) {
                $sql2 = "select nome from ejbsm_usuario where login = '$r->login';";
                $res = $link->query($sql2);
                $nome = mysqli_fetch_object($res);
                echo "<font color='white'>$nome->nome</font><br>";
            }
            echo "</div></td>";
        }
        echo "</tr>";
        $h += 1;
        $h2 += 1;
    }
    echo "</table>";
}

?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="alert alert-info">Horário completo de bolsistas.</div>
        <!-- Button trigger modal -->
        <button type="button" title="Ver horários" class="btn btn-info btn-block"
                data-toggle="modal" data-target="#ModalHorarioCompleto">
            <span class="glyphicon glyphicon-eye-open"></span> Ver horários
        </button>
        <!-- Modal -->
        <div class="modal fade" id="ModalHorarioCompleto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="width: 94%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Horário dos bolsistas</h4>
                    </div>
                    <div class="modal-body">
                        <?
                        PegaHorarios(1, null, $link);
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Lista de bolsistas ativos</h3>
        <?
        $sql = "select * from ejbsm_usuario, ejbsm_integrante where permissao = 'bolsista' and status='Ativo' and ejbsm_integrante.login=ejbsm_usuario.login ORDER by status;";
        $qr = $link->query($sql);
        while ($bolsista = mysqli_fetch_object($qr)) { ?>
            <br><br>
            <div id='cssmenu' title="Clique para expandir">
                <ul>
                    <li class='active has-sub'>
                        <a>
                    <span>
                        <table>
                            <tr>
                                <td rowspan="3" style="width: 15%;" colspan="2">
                                    <? Imagem($bolsista->login, 80) ?>
                                </td>
                                <td style="width: 35%;"><b>Nome: </b><? echo "{$bolsista->nome}"; ?></td>
                                <td style="width: 25%;"><b>Login: </b><? echo "{$bolsista->login}"; ?></td>
                                <td style="width: 35%;"><b>E-mail: </b><? echo "{$bolsista->email}"; ?></td>
                            </tr>
                        </table>
                    </span>
                        </a>
                        <ul>
                            <li class='has-sub'>
                                <a>
                            <span>
                                <table class="table">
                                    <tr>
                                        <td style="width: 15%;"><b>Celular: </b><?= $bolsista->celular; ?></td>
                                        <td style="width: 15%;"><b>Fixo: </b><?= $bolsista->fixo; ?></td>
                                        <td style="width: 15%;"><b>Matrícula: </b><?= $bolsista->id; ?></td>
                                        <td style="width: 15%;"><b>CPF: </b><?= $bolsista->cpf; ?></td>
                                        <td style="width: 15%;"><b>RG: </b><?= $bolsista->rg; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%;"><b>Órgão Expedidor: </b><?= $bolsista->orgao; ?></td>
                                        <td style="width: 15%;"><b>Área: </b><?= $bolsista->area; ?></td>
                                        <td style="width: 15%;"><b>Ênfase: </b><?= $bolsista->subarea; ?></td>
                                        <td style="width: 15%;"><b>Projeto: </b><?= $bolsista->projeto; ?></td>
                                        <td style="width: 15%;"><b>Status: </b><?= $bolsista->status; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" width="100%">
                                            <? PegaHorarios(2, $bolsista->login, $link); ?>
                                        </td>
                                    </tr>
                                    <?
                                    if ($user_permissao == "administrador" or $user_permissao == "orientador") { ?>
                                        <tr>
                                            <td>
                                                <form action="e-jbsm_editar_bolsista.php" method="post">
                                                    <div class="input-group">
                                                        <input type="hidden" name="bolsista_login"
                                                               value="<?= $bolsista->login ?>">
                                                        <button class="btn btn-warning" type="submit"
                                                                value="Editar Informações">
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                            Editar informações
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                </table>
                            </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <?
        }
        ?>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Lista de bolsistas inativos</h3>
        <?
        if (isset($_GET["info"]) and $_GET["info"] == "editado") {
            echo "<div class='alert alert-success' role='alert'>Dados do bolsista foram alterados!</div>";
        }
        $sql = "select * from ejbsm_usuario, ejbsm_integrante where permissao = 'bolsista' and status='Inativo' AND ejbsm_integrante.login=ejbsm_usuario.login ORDER by status;";
        $qr = $link->query($sql);
        while ($bolsista = mysqli_fetch_object($qr)) { ?>
            <br><br>
            <div id='cssmenu' style='box-shadow: 1px 1px 5px 1px #c9302c;'>
                <ul>
                    <li class='active has-sub'>
                        <a>
                    <span>
                        <table>
                            <tr>
                                <td rowspan="3" style="width: 15%;" colspan="2">
                                    <? Imagem($bolsista->login, 80); ?>
                                </td>
                                <td style="width: 35%;"><b>Nome: </b><? echo "{$bolsista->nome}"; ?></td>
                                <td style="width: 25%;"><b>Login: </b><? echo "{$bolsista->login}"; ?></td>
                                <td style="width: 35%;"><b>E-mail: </b><? echo "{$bolsista->email}"; ?></td>
                            </tr>
                        </table>
                    </span>
                        </a>
                        <ul>
                            <li class='has-sub'>
                                <a>
                            <span>
                                <table class="table">
                                    <tr>
                                        <td style="width: 15%;"><b>Celular: </b><?= $bolsista->celular; ?></td>
                                        <td style="width: 15%;"><b>Fixo: </b><?= $bolsista->fixo; ?></td>
                                        <td style="width: 15%;"><b>Matrícula: </b><?= $bolsista->id; ?></td>
                                        <td style="width: 15%;"><b>CPF: </b><?= $bolsista->cpf; ?></td>
                                        <td style="width: 15%;"><b>RG: </b><?= $bolsista->rg; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%;"><b>Órgão Expedidor: </b><?= $bolsista->orgao; ?></td>
                                        <td style="width: 15%;"><b>Área: </b><?= $bolsista->area; ?></td>
                                        <td style="width: 15%;"><b>Ênfase: </b><?= $bolsista->subarea; ?></td>
                                        <td style="width: 15%;"><b>Projeto: </b><?= $bolsista->projeto; ?></td>
                                        <td style="width: 15%;"><b>Status: </b><?= $bolsista->status; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" width="100%">
                                            <table>
                                                <tr>
                                                    <td></td>
                                                    <td style='width: 18%'><font size='5' color='#556b2f'>Seg</font>
                                                    </td>
                                                    <td style='width: 18%'><font size='5' color='#556b2f'>Ter</font>
                                                    </td>
                                                    <td style='width: 18%'><font size='5' color='#556b2f'>Qua</font>
                                                    </td>
                                                    <td style='width: 18%'><font size='5' color='#556b2f'>Qui</font>
                                                    </td>
                                                    <td style='width: 18%'><font size='5' color='#556b2f'>Sex</font>
                                                    </td>
                                                </tr>
                                                <? PegaHorarios(2, $bolsista->login, $link); ?>
                                            </table>
                                        </td>
                                    </tr>
                                    <?
                                    if ($user_permissao == "administrador" or $user_permissao == "orientador") { ?>
                                        <tr>
                                            <td>
                                                <form action="e-jbsm_editar_bolsista.php" method="post">
                                                    <div class="input-group">
                                                        <input type="hidden" name="bolsista_login"
                                                               value="<?= $bolsista->login ?>">
                                                        <button class="btn btn-warning" type="submit"
                                                                value="Editar Informações">Editar informações
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                </table>
                            </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <?
        }
        ?>
    </div>
</div>
