<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Carregar o arquivo XML (se não existir, criar um novo)
    if (file_exists("usuarios.xml")) {
        $usuarios = simplexml_load_file("usuarios.xml");
    } else {
        $usuarios = new SimpleXMLElement('<usuarios></usuarios>');
    }

    // Adicionar novo usuário
    $novo = $usuarios->addChild("usuario");
    $novo->addChild("nome", $_POST['nome']);
    $novo->addChild("celular", $_POST['celular']);
    $novo->addChild("email", $_POST['email']);
    $novo->addChild("senha", md5($_POST['senha'])); 
    // Salvar no arquivo
    $usuarios->asXML("usuarios.xml");

    echo "Usuário cadastrado com sucesso! <a href='cadastro.php'>Voltar</a>";
} else {
?>
<form method="post" action="cadastro.php">
    Nome: <input type="text" name="nome" required><br>
    Celular: <input type="text" name="celular" required><br>
    Email: <input type="email" name="email" required><br>
    Senha: <input type="password" name="senha" required><br>
    <input type="submit" value="Cadastrar">
</form>
<?php } ?>
