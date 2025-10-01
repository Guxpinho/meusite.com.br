<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarios = simplexml_load_file('usuarios.xml');
foreach ($usuarios->usuario as $u) {
    if ($u->email == $_POST['email'] && $u->senha == md5($_POST['senha'])) {
        
        $_SESSION['usuario'] = (string)$u->email;
        echo "login realizado com sucesso!
        <a href='criar_topico.php'>Criar tópico</a>"
        ;
        exit;
    }
}
echo "Email ou senha incorretos!";
} else {
    ?>
<form method="post">
    Email: <input type="email" name="email" required><br>
    Senha: <input type="password" name="senha" required><br>
    <button> type="submit">Entrar</button>
</form>
<?php
}
?>