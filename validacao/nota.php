<?php
$nota1 = $_POST["nota1"];
$nota2 = $_POST["nota2"];
$disciplina = $_POST["disciplina"];

function nota_calculo($nota1, $nota2, $disciplina) {
    $media = ($nota1 + $nota2) / 2;

    if ($media >= 7) {
        return "$disciplina, Aprovado (Média: $media)";
    } elseif ($media >= 5 && $media < 7) {
        return "$disciplina, Recuperação (Média: $media)";
    } else {
        return "$disciplina, Reprovado (Média: $media)";
    }
}

echo nota_calculo($nota1, $nota2, $disciplina);
?>
