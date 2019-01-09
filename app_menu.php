<ul id="sidebar" class="nav nav-pills nav-stacked" style="max-width: 200px;">
    <li><a href="app.php"><span class="glyphicon glyphicon-search"></span> Plantas</a></li>
    <li><a href="app_trilha.php"><span class="glyphicon glyphicon-edit"></span> Trilhas</a></li>
    <?if ($user_permissao == "administrador" or $user_permissao == "orientador") {?>
    <li><a href="app_cadastro_planta.php"><span class="glyphicon glyphicon-pencil"></span> Cadastro de plantas</a> </li>
    <li><a href="app_editar_planta.php"><span class="glyphicon glyphicon-edit"></span> Editar plantas</a></li>
    <li><a href="app_cadastro_trilha.php"><span class="glyphicon glyphicon-pencil"></span> Cadastro de trilhas</a> </li>
    <li><a href="app_editar_trilha.php"><span class="glyphicon glyphicon-edit"></span> Editar trilhas</a> </li>
    <li><a href="app_qrcode.php"><span class="glyphicon glyphicon-qrcode"></span> Gerar QR Code</a> </li>
    <?}?>
</ul>