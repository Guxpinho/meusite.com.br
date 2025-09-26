<?php
$pastaDestino = "uploads/";

if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
    $nomeArquivo = $_FILES['arquivo']['name'];
    $caminhoCompleto = $pastaDestino . basename($nomeArquivo);

    $tipoArquivo = strtolower(pathinfo($caminhoCompleto, PATHINFO_EXTENSION));
    $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($tipoArquivo, $tiposPermitidos)) {
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminhoCompleto)) {
            echo "O arquivo " . htmlspecialchars(basename($nomeArquivo)) . " foi enviado com sucesso.";
        } else {
            echo "Houve um erro ao enviar o arquivo.";
        }
    } else {
        echo "Tipo de arquivo não permitido. Apenas JPG, JPEG, PNG e GIF são aceitos.";
    }




}

?>
  