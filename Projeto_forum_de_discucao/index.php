<?php
    session_start();
    $topicos = simplexml_load_file("topicos.xml")
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fórum Carros</title>
</head>
<body>
    <h1>Fórum de Discussão</h1>
    <nav>
        <a href="cadastro.php">Cadastro Usúario</a>
        <a href="login.php">login</a>
        <a href="criar_topico.php">Criar Tópico</a>
    </nav>
    <hr>

    <h2>Tópicos:</h2>
    <ul>
        <?php
        $i = 0;
        foreach ($topicos -> $topicos as $t) {
            echo "<li>
                <a href= 'listar.php?id=$i'>" . $t->titulo . "</a>
                </li>";
            $i++;
        }
        ?>
    </ul>
</body>
</html>