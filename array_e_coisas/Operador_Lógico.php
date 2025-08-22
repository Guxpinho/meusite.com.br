<?php
$idade = 20;
$temCarteira = true;
$feriado = false;
$fimdeSemana = false;

if ($feriado || $temCarteira) {
    echo "pode ir sim!!";
} else {
    echo "Dia útil de trabalho";
}
?>
