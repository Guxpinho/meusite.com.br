<?php
    $arquivo = fopen("dados.txt","w");
    fwrite($arquivo,"primeira linha do texto");
    fclose($arquivo);
    echo"Seu arquivo foi criado com sucesso!";



?>
