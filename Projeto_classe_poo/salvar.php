<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: auto;
            border: solid 2px black;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            width: 50%;
    
        }
        a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #333;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
require_once "Aluno.php";
require_once "Professor.php";   
require_once "Usuario.php";

$banco = 'banco.json';

// Inicializa os dados
$dados = [];

// Verifica se o arquivo existe e carrega os dados
if (file_exists($banco)) {
    $json = file_get_contents($banco);
    $dados = json_decode($json, true);

    if (!is_array($dados)) {
        $dados = [];
    }
}

// Recebe os dados do formulário
$tipo = $_POST['tipo'] ?? '';
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';

if ($tipo === 'professor') {
    $disciplina = $_POST['disciplina'] ?? '';
    $usuario = new Professor($nome, $email, $disciplina);

    // Garante que a chave 'professores' exista
    if (!isset($dados['professores'])) {
        $dados['professores'] = [];
    }

    $dados['professores'][] = [
        'tipo' => 'professor',
        'nome' => $usuario->getNome(),
        'email' => $usuario->getEmail(),
        'disciplina' => $usuario->getDisciplina()
    ];

} elseif ($tipo === 'aluno') {
    $matricula = $_POST['matricula'] ?? '';
    $usuario = new Aluno($nome, $email, $matricula);

    // Garante que a chave 'alunos' exista
    if (!isset($dados['alunos'])) {
        $dados['alunos'] = [];
    }

    $dados['alunos'][] = [
        'tipo' => 'aluno',
        'nome' => $usuario->getNome(),
        'email' => $usuario->getEmail(),
        'matricula' => $usuario->getMatricula()
    ];
} else {
    echo "Tipo de usuário inválido!";
    exit;
}

// Salva os dados no JSON
file_put_contents($banco, json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "Usuário cadastrado com sucesso!";
echo "<br><a href='index.html'>Voltar</a>";
echo "<br><a href='teste.php'>Ver Usuários Cadastrados</a>";
?>

</body>
</html>
