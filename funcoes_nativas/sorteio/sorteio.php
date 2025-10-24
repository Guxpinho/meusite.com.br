<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo'); // Horário de Brasília

$arquivo = "participantes.json";
$resultadoArquivo = "resultado.json";

// Carrega os arquivos JSON
$participantes = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];
$resultados = file_exists($resultadoArquivo) ? json_decode(file_get_contents($resultadoArquivo), true) : [];

// Intervalo definido pelo usuário
$min = isset($_POST['min']) ? (int)$_POST['min'] : 1;
$max = isset($_POST['max']) ? (int)$_POST['max'] : 1000;

// E-mails que já ganharam
$jaGanharam = array_column($resultados, 'ganhador_email');

// Participantes disponíveis (ainda não ganharam)
$disponiveis = array_filter($participantes, function ($p) use ($jaGanharam, $min, $max) {
    $num = $p['numero'] ?? 0;
    return !in_array($p['email'], $jaGanharam) && $num >= $min && $num <= $max;
});

// Todos os prêmios cadastrados
$todosPremios = array_unique(array_column($participantes, 'premio'));

// Prêmios já sorteados
$premiosSorteados = array_column($resultados, 'premio');

// Prêmios restantes
$premiosDisponiveis = array_values(array_diff($todosPremios, $premiosSorteados));

$novoResultado = null;

// Quando clicar em sortear
if ($_POST['sortear'] ?? false) {
    if (!empty($disponiveis) && !empty($premiosDisponiveis)) {

        // Embaralha prêmios para variar
        shuffle($premiosDisponiveis);

        $ganhadorEscolhido = null;
        $premioEscolhido = null;

        // Tenta achar um ganhador que não seja o dono do prêmio
        foreach ($premiosDisponiveis as $premio) {
            $possiveisGanhadores = array_filter($disponiveis, function ($p) use ($premio) {
                return strtolower(trim($p['premio'])) !== strtolower(trim($premio));
            });

            if (!empty($possiveisGanhadores)) {
                $ganhadorEscolhido = $possiveisGanhadores[array_rand($possiveisGanhadores)];
                $premioEscolhido = $premio;
                break;
            }
        }

        // Registra o sorteio
        if ($ganhadorEscolhido && $premioEscolhido) {
            $novoResultado = [
                "numero_sorteado" => $ganhadorEscolhido['numero'],
                "premio" => $premioEscolhido,
                "ganhador_nome" => $ganhadorEscolhido['nome'],
                "ganhador_email" => $ganhadorEscolhido['email'],
                "ganhador_telefone" => $ganhadorEscolhido['telefone'],
                "data_hora" => date('d/m/Y H:i:s')
            ];

            $resultados[] = $novoResultado;
            file_put_contents($resultadoArquivo, json_encode($resultados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sorteio Automático</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #000055ff;
      color: #fff;
      margin: 0;
      padding: 20px;
      text-align: center;
    }
    .container {
      max-width: 1000px;
      margin: 0 auto;
      text-align: center;
    }
    h1 {
      color: #FFD700;
      font-size: 42px;
      margin-bottom: 30px;
    }
    form {
      background: #fff;
      color: #000;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 30px;
      display: inline-block;
    }
    input {
      padding: 8px;
      width: 80px;
      font-size: 16px;
      margin: 0 5px;
    }
    button {
      background: #FFD700;
      color: #000;
      padding: 10px 30px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }
    button:hover {
      background: #FFA500;
    }
    .telao {
      background: #222;
      border: 3px solid #FFD700;
      padding: 40px;
      border-radius: 10px;
      margin-bottom: 30px;
    }
    .numero {
      font-size: 100px;
      color: #FFD700;
      font-weight: bold;
    }
    .nome {
      font-size: 30px;
      margin-top: 10px;
    }
    .premio {
      font-size: 26px;
      color: #00FF7F;
      margin-top: 15px;
    }
    .data {
      margin-top: 10px;
      font-size: 18px;
      color: #aaa;
    }
    .ganhadores {
      background: #fff;
      color: #000;
      padding: 20px;
      border-radius: 10px;
      text-align: left;
    }
    .ganhador {
      padding: 10px;
      border-bottom: 1px solid #ccc;
    }
    .ganhador strong {
      color: #0f3460;
    }
    a {
      margin-top: 20px;
      text-decoration: none;
      color: #fff;
      background: #ff0000ff;
      padding: 10px 20px;
      border-radius: 5px;
      text-align: center;


    }
  </style>
</head>
<body>
  <div class="container">
    <h1>🎉 SORTEIO AUTOMÁTICO 🎉</h1>

    <form method="POST">
      <label>De: <input type="number" name="min" value="<?= $min ?>" min="1"></label>
      <label>Até: <input type="number" name="max" value="<?= $max ?>" min="1"></label>
      <button type="submit" name="sortear">SORTEAR</button>
      <div style="margin-top:10px;font-size:14px;">
        Participantes disponíveis: <?= count($disponiveis) ?> |
        Prêmios restantes: <?= count($premiosDisponiveis) ?>
      </div>
    </form>

    <div class="telao">
      <?php if ($novoResultado): ?>
        <div class="numero"><?= $novoResultado['numero_sorteado'] ?></div>
        <div class="nome"><?= htmlspecialchars($novoResultado['ganhador_nome']) ?></div>
        <div class="premio"><?= htmlspecialchars($novoResultado['premio']) ?></div>
        <div class="data">⏰ <?= $novoResultado['data_hora'] ?></div>
      <?php else: ?>
        <div style="opacity:0.6;font-size:40px;">Aguardando sorteio...</div>
      <?php endif; ?>
    </div>

    <div class="ganhadores">
      <h2>🏆 Lista de Ganhadores</h2>
      <?php if (empty($resultados)): ?>
        <p>Nenhum sorteio realizado ainda.</p>
      <?php else: ?>
        <?php foreach (array_reverse($resultados) as $r): ?>
          <div class="ganhador">
            <strong><?= htmlspecialchars($r['ganhador_nome']) ?></strong> (Nº <?= $r['numero_sorteado'] ?>)
            ganhou <b><?= htmlspecialchars($r['premio']) ?></b><br>
            <small><?= htmlspecialchars($r['ganhador_email']) ?> | <?= htmlspecialchars($r['ganhador_telefone']) ?> | <?= $r['data_hora'] ?></small>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
  <a href="index.html" class="sair">Sair</a>
</body>
</html>
