<div id="imagemPerfilForum">
    <?
    function Imagem($login, $max)
    {
        $x = 100;
        if (file_exists("arquivos_imagem_perfil/$login.jpg")) {
            chmod("arquivos_imagem_perfil/$login.jpg", 0755);
            list($largura, $altura) = getimagesize("arquivos_imagem_perfil/$login.jpg");

            $x = ($altura * $max) / $largura;

            echo "<a href='forum_info.php?info=login&login=$login'><img src='arquivos_imagem_perfil/$login.jpg' width='$max' height='$x'></a>";
        } else {
            echo "<a href='forum_info.php?info=login&login=$login'><img src='arquivos_imagem_perfil/user.png' width='$max' height='$x'></a>";
        }
    }

    ?>
</div>