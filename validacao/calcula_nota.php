<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cálculo da Nota</title>
</head>
<body style="margin:0; height:100vh; display:flex; justify-content:center; align-items:center; background-color: rgb(96, 96, 96);">
  <form action="nota.php" method="post" style="width: 500px; height: 200px; border: 2px solid rgb(6, 6, 6); padding: 15px; background-color: aliceblue;">
    Disciplina<br>
    <input type="text" name="disciplina" style="width: 100%; margin-bottom: 10px;"/><br>
    Nota 1<br>
    <input type="text" name="nota1" style="width: 100%; margin-bottom: 15px;"/>
    Nota 2<br>
     <input type="text" name="nota2" style="width: 100%; margin-bottom: 15px;"/><br>
    <input type="submit" value="Calcular" style="width: 100%; background-color: brown; color: white; border:none; padding: 10px; cursor: pointer;"/>
  </form>
</body>
</html>
