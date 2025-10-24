<?php
header('Content-Type: text/html; charset=utf-8');

$arquivo = "participantes.json";

// Lê o arquivo existente
$dados = [];
if (file_exists($arquivo)) {
    $conteudo = file_get_contents($arquivo);
    $dados = json_decode($conteudo, true) ?: [];
}

// Pega os dados do formulário
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$premio = $_POST['premio'] ?? '';

// Verificar se o email já está cadastrado
$emailExiste = false;
foreach ($dados as $participante) {
    if (strtolower(trim($participante['email'])) === strtolower(trim($email))) {
        $emailExiste = true;
        break;
    }
}

$mensagem = '';
$tipo = '';
$numeroSorte = null;

if ($emailExiste) {
    $mensagem = "Este email já está cadastrado no sorteio!";
    $tipo = 'erro';
} elseif ($nome && $email && $telefone && $premio) {
    // Gera um número aleatório único de 1 a 1000
    $numerosExistentes = array_column($dados, 'numero');
    $tentativas = 0;
    
    do {
        $numeroAleatorio = rand(1, 1000);
        $tentativas++;
        
        // Evitar loop infinito se todos os números já foram usados
        if ($tentativas > 10000) {
            $mensagem = "Não foi possível gerar um número único. Sistema cheio!";
            $tipo = 'erro';
            break;
        }
    } while (in_array($numeroAleatorio, $numerosExistentes));

    if (!$mensagem) {
        $novo = [
            "nome" => trim($nome),
            "email" => trim($email),
            "telefone" => trim($telefone),
            "premio" => trim($premio),
            "numero" => $numeroAleatorio
        ];

        $dados[] = $novo;
        file_put_contents($arquivo, json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $mensagem = "Participante cadastrado com sucesso!";
        $tipo = 'sucesso';
        $numeroSorte = $numeroAleatorio;
    }
} else {
    $mensagem = "Preencha todos os campos obrigatórios!";
    $tipo = 'erro';
}
?>
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title><?= $tipo === 'sucesso' ? 'Cadastro Realizado' : 'Erro no Cadastro' ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: Arial, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
            text-align: center;
        }
        
        .icone {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        .mensagem {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        
        .numero-sorte {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            color: #000;
            padding: 30px;
            border-radius: 15px;
            margin: 25px 0;
            box-shadow: 0 6px 20px rgba(255,215,0,0.4);
        }
        
        .numero-sorte .label {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .numero-sorte .numero {
            font-size: 72px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .info-adicional {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            font-size: 14px;
            color: #666;
            text-align: left;
        }
        
        .info-adicional strong {
            color: #333;
        }
        
        .botoes {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .btn {
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            display: inline-block;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        
        .btn-voltar {
            background: #667eea;
            color: white;
        }
        
        .btn-voltar:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }
        
        .btn-sorteio {
            background: #FFD700;
            color: #000;
        }
        
        .btn-sorteio:hover {
            background: #FFA500;
            transform: translateY(-2px);
        }
        
        .erro-box {
            background: #ffebee;
            border-left: 5px solid #f44336;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        
        .erro-box .mensagem {
            color: #c62828;
        }
        
        @keyframes aparecer {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .container {
            animation: aparecer 0.5s ease-out;
        }
    </style>
</head>
<body>
    <div class='container'>
        <?php if ($tipo === 'sucesso'): ?>
            <div class='icone'>✅</div>
            <div class='mensagem'><?= htmlspecialchars($mensagem) ?></div>
            
            <div class='numero-sorte'>
                <div class='label'>SEU NÚMERO DA SORTE É:</div>
                <div class='numero'><?= $numeroSorte ?></div>
            </div>
            
            <div class='info-adicional'>
                <strong>📋 Dados Cadastrados:</strong><br><br>
                <strong>Nome:</strong> <?= htmlspecialchars($nome) ?><br>
                <strong>Email:</strong> <?= htmlspecialchars($email) ?><br>
                <strong>Telefone:</strong> <?= htmlspecialchars($telefone) ?><br>
                <strong>Prêmio:</strong> <?= htmlspecialchars($premio) ?><br><br>
                <em>⚠️ Guarde bem seu número! Ele será usado no sorteio.</em>
            </div>
            
        <?php else: ?>
            <div class='icone'>❌</div>
            <div class='erro-box'>
                <div class='mensagem'><?= htmlspecialchars($mensagem) ?></div>
            </div>
        <?php endif; ?>
        
        <div class='botoes'>
            <a href='index.html' class='btn btn-voltar'>⬅️ Voltar</a>
            <a href='sorteio.php' class='btn btn-sorteio'>🎲 Ver Sorteio</a>
        </div>
    </div>
</body>
</html>