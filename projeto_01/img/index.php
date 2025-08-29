<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Document</title>
</head>
<body style="margin:0; height:100vh; display:flex; justify-content:center; align-items:center; background-color: black;">
  <form action="login.php" method="post" style="width: 500px; height: 150px; border: 2px solid black; padding: 15px; background-color: aliceblue; text-align: center;">
    Login<br>
    <input type="text" name="usuario" style="width: 100%; margin-bottom: 10px;"/><br>
    Senha<br>
    <input type="password" name="senha" style="width: 100%; margin-bottom: 15px;"/><br>
    <input type="submit" value="Entrar" style="width: 100%; background-color: brown; color: white; border:none; padding: 10px; cursor: pointer;"/>
  </form>


<?php
 // Exibe mensagem de erro, se existir
    if (isset($_GET['msg'])) {
        echo "<p style='color:red'>" . htmlspecialchars($_GET['msg']) . "</p>";
}
?>
</body>
</html>

