<?php
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
    $topicos = simplexml_load_file("topicos.xml");
    $id = intval($_POST['id']);
    $coentario = $topicos->topico[$id]->comentarios->addChild("comentario");
    $comentario->addChild('nome', $_POST['nome']);
    $comentario->addChild('mensagem', date('mensagem'));
    $topicos->asXML("topicos.xml");
    header("Location: index.php");
}