<?php
$pessoa = ["nome" => "joão", "idade" => 30];
echo "olá " . $pessoa["nome"] . ", você tem " . $pessoa["idade"] . " anos.<br>";

$pessoa = [
    "nome" => "Gustavo",
    "idade" => 17,
    "cpf" => "129813380",
    "rg" => "19290193",
    "peso" => "73,4",
];
echo "Nome: " . $pessoa["nome"] . "<br>" . "idade: " . $pessoa['idade'] . "<br>" . "essa é seu cpf: " . $pessoa['cpf'] . "<br>" ;
echo "esse é seu rg: " . $pessoa["rg"] . "<br>" ."esse é seu peso: " . $pessoa["peso"] . "<br>";


$pessoa = [ //Usar extract()para transformar chaves do array em variáveis
    "nome" => "Gustavo",
    "idade" => 17,
    "cpf" => "129813380",
    "rg" => "19290193",
    "peso" => "73,4",
];

extract($pessoa); // cria $nome, $idade, $cpf, $rg, $peso auto

echo "Nome: $nome<br>";
echo "Idade: $idade<br>";
?>

