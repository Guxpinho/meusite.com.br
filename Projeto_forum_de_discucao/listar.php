<?php
session_start();
$topicos = simplexml_load_file('topicos.xml');
$i = 0;
foreach ($topicos->topico as $t) {
    echo "<h2>" . $t->titulo . "</h2>";
    echo "<p>" . $t->descricao . "</p>";
    echo "<small>Autor: " . $t->autor . " | Data: " . $t->data . "</small>";
    echo "<h3>Comentários</h3>";
    $i = 0;
    foreach ($t->comentarios->comentario as $c) {
        echo "<p><b>" . $c->nome . "</b>: " . $c->mensagem;
        if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == $c->nome) {
            echo " <a href='excluir_comentario.php?topico=" . $i . "&comentario=" . $j . "'>Excluir</a>";
        }
        echo "</p>";
        $j++;
    }
    echo "<form method='post' action='comentar.php'>
    <input type='hidden' name='topico' value='$i'>
    nome: <input type='text' name='nome' required><br>
    mensagem: <input type='text' name='mensagem' required><br>
    <button type='submit'>Comentar</button>
</form><hr>";
$i++;
}
?>