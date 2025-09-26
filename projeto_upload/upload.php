<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Enviar Imagem</h1>
    <form action="processa_upload.php" method="post" enctype="multipart/form-data">
        <label>selecione a imagem:</label><br><br>
        <input type="file" name="arquivo" accept="image/*" required><br><br>
        <button type="submit">Enviar</button>
    </form>
    <br>
    <a href="index.php">Voltar para a galeria</a>
</body>
</html>