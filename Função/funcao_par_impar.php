
<?php
    $n1 = $_REQUEST["n1"];
function parOuImpar($num) {
    if ($num % 2 == 0) {
        return "O seu numero é par";
    } else {
        return "O seu numero é impar";
    }
}

echo parOuImpar($n1);
?>






