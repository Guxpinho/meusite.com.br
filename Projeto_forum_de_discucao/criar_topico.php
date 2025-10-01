<?php 
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "Acesso negado. Faça login para criar tópicos.";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topicos = simplexml_load_file("topicos.xml");
    $novo = $topicos->addChild("topicos");
    $novo->addChild("titulo", $_POST['titulo']);
    $novo->addChild("titulo", $_POST['titulo']);
    $novo->addChild("mensagem", $_POST['mensagem']);
    $novo->addChild("comentarios");
    $topicos->asXML("topicos.xml");
    echo "Tópico criado com sucesso! <a href = 'listar.php'> Ver tópicos</a>";
} else {
?>
<form method="POST">
    <label>Título: <input type="text" name="titulo" required></label><br>
    <label>Mensagem:<br><textarea name="mensagem" required></textarea></label><br>
    <button type="submit">Criar tópicos</button>
</form>
<?php } ?>