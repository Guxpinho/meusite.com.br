<?php
function conecta($usuario, $senha) {
         if ($usuario === "guxpinho" && $senha === "1@gustavo") {
        header("Location: painel.php");
        exit;
     }   else {
 // Codifica a mensagem para evitar problemas com acentuação
         $msg = urlencode("Usuário ou senha inválidos!");
         header("Location: index.php?msg=$msg");
        exit;

    }

}

?>
