<?php
    $arquivo = fopen("dados.txt","w");
    fwrite($arquivo,"primeira linha do texto");
    fclose($arquivo);
?>