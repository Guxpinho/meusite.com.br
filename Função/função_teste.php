<?php
    function nomedafuncao($parametro1, $parametro2) {
        $resultado = $parametro1 + $parametro2;
        return $resultado;
    }

    $soma = nomedafuncao(5, 10);
    echo "esse é seu resultado: " . $soma;
?>
