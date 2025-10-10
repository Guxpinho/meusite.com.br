<?php

$peso = $_POST['peso'];
$altura = $_POST['altura'];
$imc = $peso / ($altura * $altura);
print "Seu IMC é: " . number_format($imc, 2);
?>