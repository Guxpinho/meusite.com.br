<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        img {
            max-width: 200px;
            max-height: 200px;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
        h1, h2 {
            color: #333;
        }
        hr {
            margin: 20px 0;
        }
        .image-container {
            display: inline-block;
            margin: 10px;
            border: 1px solid #ccc;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Galeria de imagens</h1>
    <a href="upload.php">Enviar nova imagem</a>
    <hr>

    <h2>Imagens enviadas</h2>
    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
        <?php
        $pasta = "uploads/";
        if (is_dir($pasta)) {
            $arquivos = scandir($pasta);
            foreach ($arquivos as $arquivo) {
                if ($arquivo !== '.' && $arquivo !== '..') {
                    echo '<div style="border: 1px solid #ccc; padding: 5px;">
                            <img src="' . $pasta . $arquivo . '" style="border: 1px solid #ccc;">
                          </div>';
                }
            }
        } else {
            echo "<p>Nenhuma imagem enviada até o momento.</p>";
    }
        ?>
    </div>
</body>
</html>