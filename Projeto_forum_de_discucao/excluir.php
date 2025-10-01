<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "Acesso negado. Faça login para criar tópicos.";
    exit();
}
$topicos = simplexml_load_file("topicos.xml");
$id = intval($_GET['id']);
$comentario_id = intval($_GET['comentario']);
if ($_SESSION['usuario'] == $topicos->topicos[$id]->autor) {
    unset($topicos->topico[$id]->comentarios->comentario[$comentario_id0]);
    $topicos->asXML("topicos.xml");

}
header("location: listar.php");
?>