<?php
function media($n1, $n2, $n3) {
    return ($n1 + $n2 + $n3) / 3;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $n1 = $_POST["n1"];
    $n2 = $_POST["n2"];
    $n3 = $_POST["n3"];
    
    $resultado = media($n1, $n2, $n3);
    echo "<h2>Resultado da média</h2>";
    echo "Os números digitados foram: $n1, $n2, $n3 <br>";
    echo "A média é: <strong>" . number_format($resultado, 2, ".", "") . "</strong>";
} else {
    echo "nenhum valor enviado";
}
?>

 